<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return view('inventory.index',compact('products'));
    }

    /**
     * Adjust Stock
     */
    public function adjust(Request $request, $id)
    {
        $request->validate([

            'quantity' => ['required','integer'],
            'type' => ['required','in:add,subtract'],
            'notes' => ['nullable','string'],
        ]);

        $product = Product::findOrFail($id);
        $before = $product->stock;
        if ($request->type === 'add') {
            $product->increment(
                'stock',
                $request->quantity
            );
        } else {
            if ($request->quantity > $product->stock) {
                return back()->with(
                    'error',
                    'Insufficient stock.'
                );
            }
            $product->decrement(
                'stock',
                $request->quantity
            );
        }

        $product->refresh();
        $after = $product->stock;
        $this->inventoryService->log(
            $product,
            'adjustment',
            $request->quantity,
            $before,
            $after,
            $request->notes
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
        $histories = \App\Models\InventoryHistory::with([
            'product',
            'user'
        ])->latest()->paginate(20);

        return view('inventory.history',compact('histories'));
    }
}