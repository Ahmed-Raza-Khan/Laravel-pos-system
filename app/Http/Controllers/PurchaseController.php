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
        $suppliers = Supplier::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        $warehouses = Warehouse::where('status',1)->get();

        return view('purchases.create', compact('suppliers', 'products', 'warehouses'));
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

        $suppliers = Supplier::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        $warehouses = Warehouse::where('status', 1)->get();

        return view('purchases.edit',compact('purchase', 'suppliers', 'products', 'warehouses'));
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
}
