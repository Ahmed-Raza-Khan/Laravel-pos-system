<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\HeldCart;
use App\Models\Setting;
use App\Models\Warehouse;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Http\Requests\RecordSalePaymentRequest;
use App\Http\Requests\HoldCartRequest;
use App\Services\SaleService;
use App\Interfaces\SaleRepositoryInterface;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected SaleService $saleService
    ) {}

    public function index()
    {
        $sales = $this->saleRepository->getAll();

        return view('sales.index', compact('sales'));
    }

    public function create(Request $request)
    {
        $warehouses = Warehouse::latest()->get();
        
        // Agar session khali hai, toh safely pehle warehouse ki ID save kar dein
        if (!session()->has('selected_warehouse_id') && $warehouses->isNotEmpty()) {
            session()->put('selected_warehouse_id', $warehouses->first()->id);
        }

        $selectedWarehouseId = session('selected_warehouse_id');

        // ... aapki baqi products wali query ...
        $products = Product::when($request->search, function ($query) use ($request) {
            // ...
        })
        ->withSum(['warehouseStocks as current_warehouse_stock' => function($query) use ($selectedWarehouseId) {
            $query->where('warehouse_id', $selectedWarehouseId);
        }], 'stock')
        ->latest()
        ->paginate(12);

        $customers = Customer::latest()->get();
        $cart = session()->get('cart', []);
        $heldCarts = HeldCart::where('user_id', auth()->id())->latest()->get();
        $checkoutMeta = session()->get('checkout_meta', []);
        
        $setting = Setting::first() ?: new Setting(['tax_percentage' => 0, 'currency' => 'PKR']);

        return view('sales.create', compact('products', 'customers', 'warehouses', 'cart', 'heldCarts', 'checkoutMeta', 'setting'));
    }

    public function edit($id)
    {
        $sale = $this->saleRepository->findById($id);

        if ($sale->status === 'voided') {
            return redirect()->route('sales.show', $sale->id)->with('error', 'Voided sales cannot be edited.');
        }

        session()->put('cart', $this->saleService->saleToCart($sale));
        session()->put('checkout_meta', [
            'customer_id' => $sale->customer_id,
            'warehouse_id' => $sale->warehouse_id,
            'discount_type' => $sale->discount_type,
            'discount_value' => $sale->discount_value,
            'tax_percentage' => $sale->tax_percentage,
            'paid_amount' => $sale->paid_amount,
            'payment_method' => $sale->payment_method,
            'notes' => $sale->notes,
            'editing_sale_id' => $sale->id,
        ]);

        session()->put('selected_warehouse_id', $sale->warehouse_id);

        return redirect()->route('sales.create')->with('success', 'Sale loaded into cart for editing.');
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        
        $warehouseId = session('selected_warehouse_id');

        if (!$warehouseId) {
            return back()->with('error', 'Please select a warehouse first.');
        }

        $warehouseStock = \App\Models\WarehouseProduct::where('warehouse_id', $warehouseId)
            ->where('product_id', $id)
            ->first();

        $availableStock = $warehouseStock ? $warehouseStock->stock : 0;

        if ($availableStock < 1) {
            return back()->with('error', "{$product->name} is out of stock in this warehouse.");
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($availableStock <= $cart[$id]['qty']) {
                return back()->with('error', 'Warehouse stock limit exceeded.');
            }
            $cart[$id]['qty']++;
            $cart[$id]['total'] = $cart[$id]['qty'] * $cart[$id]['price'];
        } else {
            $cart[$id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price,
                'qty' => 1,
                'total' => $product->sale_price,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Product added to cart.');
    }

    public function updateCart(Request $request, $id)
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
            return back()->with('error', "Stock limit exceeded. Only {$availableStock} items available in this warehouse.");
        }

        $cart[$id]['qty'] = $qty;
        $cart[$id]['total'] = $qty * $cart[$id]['price'];
        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated.');
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item removed.');
    }

    public function setWarehouse(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id'
        ]);

        // Cart clear karne wali logic yahan se hata di gayi hai
        session()->put('selected_warehouse_id', $request->warehouse_id);

        return back()->with('success', 'Warehouse switched. Cart items retained.');
    }
    // public function clearCart()
    // {
    //     session()->forget(['cart', 'checkout_meta']);

    //     return back()->with('success', 'Cart cleared.');
    // }

    public function holdCart(HoldCartRequest $request)
    {
        try {
            $this->saleService->holdCart(
                $request->reference,
                $request->only(['customer_id', 'discount_type', 'discount_value', 'tax_percentage', 'notes'])
            );

            return back()->with('success', 'Cart held successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function resumeCart($id)
    {
        try {
            $this->saleService->resumeHeldCart($id);

            return redirect()->route('sales.create')->with('success', 'Held cart resumed.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(StoreSaleRequest $request)
    {
        try {
            $meta = session('checkout_meta', []);
            $editingId = $meta['editing_sale_id'] ?? null;

            if ($editingId) {
                $sale = $this->saleService->updateSale($editingId, $request->validated(), session('cart', []));
                session()->forget(['cart', 'checkout_meta']);

                return redirect()->route('sales.show', $sale->id)->with('success', 'Sale updated successfully.');
            }

            $sale = $this->saleService->createSale($request->validated());

            return redirect()->route('sales.show', $sale->id)->with('success', 'Sale completed.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(UpdateSaleRequest $request, $id)
    {
        try {
            $sale = $this->saleService->updateSale($id, $request->validated(), session('cart', []));
            session()->forget(['cart', 'checkout_meta']);

            return redirect()->route('sales.show', $sale->id)->with('success', 'Sale updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $sale = $this->saleRepository->findById($id);
        $sale->load(['payments.receiver']);
        $setting = Setting::first() ?: new Setting(['currency' => 'PKR']);

        return view('sales.show', compact('sale', 'setting'));
    }

    public function void($id)
    {
        try {
            $this->saleService->voidSale($id);

            return redirect()->route('sales.show', $id)->with('success', 'Sale voided and stock restored.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function recordPayment(RecordSalePaymentRequest $request, $id)
    {
        try {
            $this->saleService->recordPayment($id, $request->validated());

            return back()->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
