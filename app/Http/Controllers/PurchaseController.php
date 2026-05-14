<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
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

        return view('purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store purchase.
     */
    public function store(StorePurchaseRequest $request)
    {
        $this->purchaseService
            ->createPurchase($request->validated());

        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully');
    }

    /**
     * Edit page.
     */
    public function edit(string $id)
    {
        $purchase = $this->purchaseService
            ->getPurchase($id);

        $suppliers = Supplier::where('status', 1)->get();

        $products = Product::where('status', 1)->get();

        return view('purchases.edit',compact('purchase', 'suppliers', 'products'));
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
