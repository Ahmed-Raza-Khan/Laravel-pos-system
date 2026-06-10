<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WarehouseService;
use App\Models\Warehouse;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;

class WarehouseController extends Controller
{
    protected $warehouseService;

    public function __construct(
        WarehouseService $warehouseService
    ) {
        $this->warehouseService = $warehouseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = $this->warehouseService
            ->getAllWarehouses();

        return view('warehouses.index', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseRequest $request)
    {
        $this->warehouseService->createWarehouse(
            $request->validated()
        );

        return redirect()->route('warehouses.index')->with('success', 'Warehouse created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $warehouse = Warehouse::with(['products' => function($query) {
            $query->select('products.id', 'products.name', 'products.sku', 'products.sale_price')
                  ->withPivot('stock');
        }])->findOrFail($id);

        return view('warehouses.show', compact('warehouse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $warehouse = $this->warehouseService->getWarehouse($id);

        return view('warehouses.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, string $id)
    {
        $this->warehouseService->updateWarehouse(
            $id,
            $request->validated()
        );

        return redirect()->route('warehouses.index')->with('success','Warehouse updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->warehouseService->deleteWarehouse($id);

        return redirect()->route('warehouses.index')->with('success','Warehouse deleted successfully.');
    }
}
