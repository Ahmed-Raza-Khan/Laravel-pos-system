<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Services\PurchaseService;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;

class PurchaseController extends Controller
{
    protected $purchaseService;
    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    /**
     * Display purchases.
     */
    public function index()
    {
        $purchases = $this->purchaseService
            ->getAllPurchases();

        return view('purchases.index', compact('purchases'));
    }

    /**
     * Create purchase page.
     */
    public function create()
    {
        $products = Product::where('status', 1)->get();
        $warehouses = Warehouse::where('status', 1)->get();
        $suppliers = collect();

        return view('purchases.create', compact('products','warehouses','suppliers'));
    }

    /**
     * Store purchase.
     */
    public function store(StorePurchaseRequest $request)
    {
        $this->purchaseService
            ->createPurchase($request->validated());

        return redirect()->route('purchases.index')->with('success', 'Purchase created. Approve it to add stock.');
    }

    public function approve(string $id)
    {
        try {
            $this->purchaseService->approvePurchase($id);

            return back()->with('success', 'Purchase approved and stock updated.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancel(string $id)
    {
        try {
            $this->purchaseService->cancelPurchase($id);

            return back()->with('success', 'Purchase cancelled.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Edit page.
     */
    public function edit(string $id)
    {
        $purchase = $this->purchaseService->getPurchase($id);
        $products = Product::where('status', 1)->get();
        $warehouses = Warehouse::where('status', 1)->get();
        $suppliers = Supplier::whereHas('warehouses', function ($q) use ($purchase) {
            $q->where('warehouses.id', $purchase->warehouse_id);
        })->where('status', 1)->get();

        return view('purchases.edit', compact('purchase','products','warehouses','suppliers'));
    }

    /**
     * Display the specified purchase invoice.
     */
    public function show(string $id)
    {
        $purchase = $this->purchaseService->getPurchase($id);
        $setting = Setting::first() ?: new Setting(['currency' => 'PKR']);

        return view('purchases.show', compact('purchase', 'setting'));
    }

    /**
     * Update purchase.
     */
    public function update(UpdatePurchaseRequest $request,string $id) 
    {
        $this->purchaseService
            ->updatePurchase(
                $id,
                $request->validated()
            );

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully');
    }

    /**
     * Delete purchase.
     */
    public function destroy(string $id)
    {
        $this->purchaseService
            ->deletePurchase($id);

        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully');
    }
    
    public function getWarehouseSuppliers(Warehouse $warehouse)
    {
        return response()->json(
            $warehouse->suppliers()->where('suppliers.status', 1)->select('suppliers.id','suppliers.name')->get()
        );
    }
}
