<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Services\SupplierService;
use App\Models\Warehouse;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = $this->supplierService->getAllSuppliers();

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehouses = Warehouse::where('status', true)->get();

        return view('suppliers.create', compact('warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $data = $request->validated();

        $this->supplierService->createSupplier($data);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = $this->supplierService->getSupplier($id);
        $warehouses = Warehouse::where('status', true)->get();

        return view('suppliers.edit', compact('supplier','warehouses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, string $id)
    {
        $data = $request->validated();

        $this->supplierService->updateSupplier($id, $data);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->supplierService->deleteSupplier($id);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully');
    }
}