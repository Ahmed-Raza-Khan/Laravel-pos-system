<?php

namespace App\Services;

use App\Models\HeldCart;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalePayment;
use Illuminate\Support\Facades\DB;
use App\Interfaces\SaleRepositoryInterface;

class SaleService
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected InventoryService $inventoryService
    ) {}

    public function createSale(array $data): Sale
    {
        DB::beginTransaction();
        try {
            $cart = session()->get('cart', []);
            if (empty($cart)) {
                throw new \Exception('Cart is empty.');
            }

            $totals = $this->buildTotals($cart, $data);
            $sale = null;
            for ($attempt = 1; $attempt <= 3; $attempt++) {
                try {
                    $sale = $this->saleRepository->create(array_merge($totals, [
                        'invoice_no' => $this->saleRepository->generateInvoiceNumber(),
                        'customer_id' => $data['customer_id'] ?? null,
                        'payment_method' => $data['payment_method'],
                        'sale_date' => now(),
                        'created_by' => auth()->id(),
                        'notes' => $data['notes'] ?? null,
                        'status' => 'completed',
                    ]));

                    break;
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($attempt == 3) {
                        throw new \Exception('Failed to generate unique invoice number.');
                    }
                }
            }

            $this->applyCartItems($sale, $cart);
            session()->forget('cart');
            DB::commit();

            return $sale;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateSale(int $id, array $data, array $cart): Sale
    {
        DB::beginTransaction();
        try {
            $sale = Sale::with('items')->findOrFail($id);

            if ($sale->status === 'voided') {
                throw new \Exception('Cannot edit a voided sale.');
            }

            if (empty($cart)) {
                throw new \Exception('Cart is empty.');
            }

            $this->restoreSaleStock($sale, 'Stock restored before sale edit.');

            SaleItem::where('sale_id', $sale->id)->delete();

            $totals = $this->buildTotals($cart, $data);
            $paidAmount = min($data['paid_amount'], $totals['grand_total']);
            $dueAmount = $totals['grand_total'] - $paidAmount;

            $sale->update(array_merge($totals, [
                'customer_id' => $data['customer_id'] ?? null,
                'payment_method' => $data['payment_method'],
                'paid_amount' => $paidAmount,
                'due_amount' => max(0, $dueAmount),
                'notes' => $data['notes'] ?? null,
            ]));

            $this->applyCartItems($sale, $cart);
            DB::commit();

            return $sale->fresh(['customer', 'items.product']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
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
        $paidAmount = min((float) ($data['paid_amount'] ?? $grandTotal), $grandTotal);
        $dueAmount = max(0, $grandTotal - $paidAmount);

        return [
            'subtotal' => $subtotal,
            'discount_type' => $data['discount_type'] ?? null,
            'discount_value' => $data['discount_value'] ?? 0,
            'discount_amount' => $discountAmount,
            'tax_percentage' => $data['tax_percentage'] ?? 0,
            'tax_amount' => $taxAmount,
            'grand_total' => $grandTotal,
            'paid_amount' => $paidAmount,
            'due_amount' => $dueAmount,
        ];
    }

    protected function applyCartItems(Sale $sale, array $cart): void
    {
        foreach ($cart as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
                'total' => $item['total'],
            ]);

            $product = Product::findOrFail($item['product_id']);
            if ($product->stock < $item['qty']) {
                throw new \Exception("{$product->name} stock not available.");
            }

            $before = $product->stock;
            $product->decrement('stock', $item['qty']);
            $product->refresh();

            $this->inventoryService->log(
                $product,
                'sale',
                $item['qty'],
                $before,
                $product->stock,
                "Stock reduced from sale #{$sale->invoice_no}."
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

            $before = $product->stock;
            $product->increment('stock', $item->quantity);
            $product->refresh();

            $this->inventoryService->log(
                $product,
                'adjustment',
                $item->quantity,
                $before,
                $product->stock,
                $note
            );
        }
    }
}
