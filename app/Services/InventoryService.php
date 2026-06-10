<?php

namespace App\Services;

use App\Models\Product;
use App\Models\InventoryHistory;
use App\Models\WarehouseProduct;
use App\Models\StockTransfer;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryService
{
    public function log(
        Product $product,
        string $type,
        int $quantity,
        int $stockBefore,
        int $stockAfter,
        ?string $notes = null,
        ?int $warehouseId = null
    ) {

        InventoryHistory::create([
            'product_id'   => $product->id,
            'warehouse_id' => $warehouseId,
            'type'         => $type,
            'quantity'     => $quantity,
            'stock_before' => $stockBefore,
            'stock_after'  => $stockAfter,
            'notes'        => $notes,
            'created_by'   => auth()->id(),
        ]);
    }

    /**
     * Transfer or Return stock between warehouses safely
     */
    public function transferStock(array $data)
    {
        return DB::transaction(function () use ($data) {
            $productId = $data['product_id'];
            $fromId = $data['from_warehouse_id'];
            $toId = $data['to_warehouse_id'];
            $qty = $data['quantity'];
            $type = $data['type'] ?? 'transfer';

            $sourceStock = WarehouseProduct::where('product_id', $productId)
                ->where('warehouse_id', $fromId)
                ->first();

            if (!$sourceStock || $sourceStock->stock < $qty) {
                throw new Exception("Source warehouse me kafi stock maujood nahi hai.");
            }

            $destStock = WarehouseProduct::firstOrCreate(
                ['product_id' => $productId, 'warehouse_id' => $toId],
                ['stock' => 0]
            );

            $fromBefore = $sourceStock->stock;
            $toBefore = $destStock->stock;

            $sourceStock->decrement('stock', $qty);
            $destStock->increment('stock', $qty);

            $transferLog = StockTransfer::create([
                'product_id'        => $productId,
                'from_warehouse_id' => $fromId,
                'to_warehouse_id'   => $toId,
                'quantity'          => $qty,
                'type'              => $type,
                'notes'             => $data['notes'] ?? null,
                'user_id'           => auth()->id(),
            ]);

            return $transferLog;
        });
    }
}