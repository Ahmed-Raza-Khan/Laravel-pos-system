<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use App\Models\InventoryHistory;
use App\Support\IndexTable;
use Illuminate\Http\Request;
use App\Services\InventoryService;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(
        InventoryService $inventoryService
    ) {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Inventory List
     */
    public function index(Request $request)
    {
        $warehouseId = $request->get('warehouse_id');

        // Main Query with exact collection mapping
        $query = Product::with([
            'category',
            'brand',
            'warehouses' => function ($query) use ($warehouseId) {
                if ($warehouseId) {
                    $query->where('warehouses.id', $warehouseId);
                }
            }
        ]);

        if ($request->filled('product_id')) {
            $query->where('id', $request->product_id);
        }

        $products = IndexTable::apply(
            $query,
            ['name', 'sku', 'barcode'],
            'name'
        );

        $allProducts = Product::select('id', 'name')->orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();

        return view(
            'inventory.index',
            compact('products', 'allProducts', 'warehouses')
        );
    }

    /**
     * Adjust Stock
     */
    public function adjust(Request $request, $id)
    {
        $request->validate([
            'warehouse_id' => [
                'required',
                'exists:warehouses,id'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'type' => [
                'required',
                'in:add,subtract'
            ],
            'notes' => [
                'nullable',
                'string'
            ],
        ]);

        $product = Product::findOrFail($id);

        $warehouseStock = WarehouseProduct::firstOrCreate(
            [
                'warehouse_id' => $request->warehouse_id,
                'product_id' => $product->id,
            ],
            [
                'stock' => 0,
            ]
        );

        $before = $warehouseStock->stock;

        if ($request->type === 'add') {

            $warehouseStock->increment(
                'stock',
                $request->quantity
            );

        } else {

            if ($request->quantity > $warehouseStock->stock) {

                return back()->with(
                    'error',
                    'Insufficient stock.'
                );
            }

            $warehouseStock->decrement(
                'stock',
                $request->quantity
            );
        }

        $warehouseStock->refresh();

        $after = $warehouseStock->stock;

        $this->inventoryService->log(
            $product,
            'adjustment',
            $request->quantity,
            $before,
            $after,
            $request->notes,
            $request->warehouse_id
        );

        return back()->with(
            'success',
            'Stock adjusted successfully.'
        );
    }

    /**
     * Inventory History
     */
    public function history()
    {
        $histories = InventoryHistory::with([
            'product',
            'user',
            'warehouse'
        ])
        ->latest()
        ->paginate(20);

        return view(
            'inventory.history',
            compact('histories')
        );
    }
}