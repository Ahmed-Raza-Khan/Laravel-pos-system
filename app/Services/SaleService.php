<?php

namespace App\Services;

use App\Models\HeldCart;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalePayment;
use App\Models\WarehouseProduct;
use Illuminate\Support\Facades\DB;
use App\Interfaces\SaleRepositoryInterface;
use App\Services\InventoryService; // <-- FIXED: Missing import added here

class SaleService
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected InventoryService $inventoryService
    ) {}

    public function createSale(array $data): Sale
    {
        return DB::transaction(function () use ($data) {

            $cart = session()->get('cart', []);

            if (empty($cart)) {
                throw new \Exception('Cart is empty.');
            }

            foreach ($cart as $item) {
                $product = \App\Models\Product::findOrFail($item['product_id']);
                
                $warehouseStock = \App\Models\WarehouseProduct::where('warehouse_id', $data['warehouse_id'])
                    ->where('product_id', $product->id)
                    ->first();

                $availableStock = $warehouseStock ? $warehouseStock->stock : 0;

                if ($availableStock < $item['qty']) {
                    throw new \Exception("{$product->name} has insufficient stock ({$availableStock} available) in the selected warehouse.");
                }
            }

            $totals = $this->buildTotals($cart, $data);

            $sale = $this->saleRepository->create(array_merge($totals, [
                'invoice_no' => $this->saleRepository->generateInvoiceNumber(),
                'customer_id' => $data['customer_id'] ?? null,
                'warehouse_id' => $data['warehouse_id'],
                'payment_method' => $data['payment_method'],
                'sale_date' => now(),
                'created_by' => auth()->id(),
                'notes' => $data['notes'] ?? null,
                'status' => 'completed',
            ]));

            $this->applyCartItems($sale, $cart);

            session()->forget(['cart', 'checkout_meta']);

            return $sale;
        });
    }

    public function updateCart(\Illuminate\Http\Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (! isset($cart[$id])) {
            return back()->with('error', 'Product not in cart.');
        }

        $product = Product::findOrFail($id);
        $qty = max(1, (int) $request->qty);
        
        $warehouseId = session('selected_warehouse_id');
        $warehouseStock = \App\Models\WarehouseProduct::where('warehouse_id', $warehouseId)
                                                    ->where('product_id', $id)
                                                    ->first();
        $availableStock = $warehouseStock ? $warehouseStock->stock : 0;

        if ($availableStock < $qty) {
            return back()->with('error', "Cannot update quantity. Only {$availableStock} items available in this warehouse.");
        }

        $cart[$id]['qty'] = $qty;
        $cart[$id]['total'] = $qty * $cart[$id]['price'];
        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated.');
    }

    public function voidSale(int $id): Sale
    {
        DB::beginTransaction();
        try {
            $sale = Sale::with('items')->findOrFail($id);

            if ($sale->status === 'voided') {
                throw new \Exception('Sale is already voided.');
            }

            $this->restoreSaleStock($sale, 'Stock restored from voided sale.');

            $sale->update([
                'status' => 'voided',
                'voided_at' => now(),
                'voided_by' => auth()->id(),
                'due_amount' => 0,
            ]);

            DB::commit();

            return $sale->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function recordPayment(int $saleId, array $data): SalePayment
    {
        DB::beginTransaction();
        try {
            $sale = Sale::findOrFail($saleId);

            if ($sale->status === 'voided') {
                throw new \Exception('Cannot collect payment on a voided sale.');
            }

            if ($sale->due_amount <= 0) {
                throw new \Exception('This sale has no due balance.');
            }

            $amount = min((float) $data['amount'], (float) $sale->due_amount);

            $payment = SalePayment::create([
                'sale_id' => $sale->id,
                'amount' => $amount,
                'payment_method' => $data['payment_method'],
                'notes' => $data['notes'] ?? null,
                'received_by' => auth()->id(),
                'paid_at' => now(),
            ]);

            $sale->update([
                'paid_amount' => $sale->paid_amount + $amount,
                'due_amount' => $sale->due_amount - $amount,
            ]);

            DB::commit();

            return $payment;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function holdCart(?string $reference = null, ?array $checkoutMeta = null): HeldCart
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            throw new \Exception('Cart is empty. Nothing to hold.');
        }

        $held = HeldCart::create([
            'user_id' => auth()->id(),
            'reference' => $reference ?: 'Hold-' . now()->format('His'),
            'cart_data' => $cart,
            'customer_id' => $checkoutMeta['customer_id'] ?? null,
            'checkout_meta' => $checkoutMeta,
        ]);

        session()->forget('cart');

        return $held;
    }

    public function resumeHeldCart(int $heldCartId): void
    {
        $held = HeldCart::where('user_id', auth()->id())->findOrFail($heldCartId);

        if (session()->has('cart') && ! empty(session('cart'))) {
            throw new \Exception('Clear or complete the current cart before resuming a held cart.');
        }

        session()->put('cart', $held->cart_data);

        if ($held->checkout_meta) {
            session()->put('checkout_meta', $held->checkout_meta);
        }

        $held->delete();
    }

    public function saleToCart(Sale $sale): array
    {
        $cart = [];
        foreach ($sale->items as $item) {
            $cart[$item->product_id] = [
                'product_id' => $item->product_id,
                'name' => $item->product?->name ?? 'Product',
                'price' => (float) $item->price,
                'qty' => (int) $item->quantity,
                'total' => (float) $item->total,
            ];
        }

        return $cart;
    }

    public function calculateSubtotal($cart): float
    {
        return (float) collect($cart)->sum('total');
    }

    public function calculateDiscount($subtotal, $type, $value): float
    {
        if (! $type || ! $value) {
            return 0;
        }
        if ($type === 'fixed') {
            return (float) $value;
        }
        if ($type === 'percentage') {
            return ($subtotal * $value) / 100;
        }

        return 0;
    }

    protected function buildTotals(array $cart, array $data): array
    {
        $subtotal = $this->calculateSubtotal($cart);
        $discountAmount = $this->calculateDiscount(
            $subtotal,
            $data['discount_type'] ?? null,
            $data['discount_value'] ?? 0
        );

        $afterDiscount = $subtotal - $discountAmount;
        $taxAmount = ($afterDiscount * ($data['tax_percentage'] ?? 0)) / 100;
        $grandTotal = $afterDiscount + $taxAmount;
        $paidAmount = (float) ($data['paid_amount'] ?? 0);

        if ($paidAmount < 0) {
            throw new \Exception('Paid amount cannot be negative.');
        }

        $dueAmount = max(0, $grandTotal - $paidAmount);

        $changeAmount = $paidAmount > $grandTotal
            ? $paidAmount - $grandTotal
            : 0;

        return [
            'subtotal' => round($subtotal, 2),
            'discount_type' => $data['discount_type'] ?? null,
            'discount_value' => $data['discount_value'] ?? 0,
            'discount_amount' => round($discountAmount, 2),
            'tax_percentage' => $data['tax_percentage'] ?? 0,
            'tax_amount' => round($taxAmount, 2),
            'grand_total' => round($grandTotal, 2),
            'paid_amount' => round($paidAmount, 2),
            'due_amount' => round($dueAmount, 2),
            'change_amount' => round($changeAmount, 2),
        ];
    }

    protected function applyCartItems(Sale $sale, array $cart): void
    {
        foreach ($cart as $item) {
            $product = Product::findOrFail($item['product_id']);
            $warehouseStock = WarehouseProduct::firstOrCreate(
                [
                    'warehouse_id' => $sale->warehouse_id,
                    'product_id'   => $product->id,
                ],
                [
                    'stock' => 0
                ]
            );

            if ($warehouseStock->stock < $item['qty']) {
                throw new \Exception("{$product->name} insufficient warehouse stock.");
            }

            if ($product->total_stock < $item['qty']) {
                throw new \Exception("{$product->name} stock not available.");
            }

            $before = $warehouseStock->stock;

            SaleItem::create([
                'sale_id'    => $sale->id,
                'product_id' => $product->id,
                'quantity'   => $item['qty'],
                'price'      => $item['price'],
                'total'      => $item['total'],
            ]);

            $warehouseStock->decrement('stock', $item['qty']);

            $product->refresh();

            // FIXED: Added missing comma after string message
            $this->inventoryService->log(
                $product,
                'sale',
                $item['qty'],
                $before,
                $warehouseStock->fresh()->stock,
                "Stock reduced from sale #{$sale->invoice_no}", 
                $sale->warehouse_id
            );
        }
    }

    protected function restoreSaleStock(Sale $sale, string $note): void
    {
        foreach ($sale->items as $item) {
            $product = Product::find($item->product_id);
            if (! $product) {
                continue;
            }

            $warehouseStock = WarehouseProduct::firstOrCreate(
                [
                    'warehouse_id' => $sale->warehouse_id,
                    'product_id' => $product->id,
                ],
                [
                    'stock' => 0,
                ]
            );

            $before = $warehouseStock->stock;

            $warehouseStock->increment('stock', $item->quantity);

            $product->refresh();

            $this->inventoryService->log(
                $product,
                'adjustment',
                $item->quantity,
                $before,
                $warehouseStock->fresh()->stock,
                $note,
                $sale->warehouse_id
            );
        }
    }
}