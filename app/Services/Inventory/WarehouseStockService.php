<?php

namespace App\Services\Inventory;

use App\Models\WarehouseProduct;

class WarehouseStockService
{
    public function increase(int $warehouseId, int $productId, int $quantity): void
    {
        $stock = WarehouseProduct::firstOrCreate(
            [
                'warehouse_id' => $warehouseId,
                'product_id' => $productId,
            ],
            [
                'stock' => 0
            ]
        );

        $stock->increment('stock',$quantity);
    }

    public function decrease(int $warehouseId, int $productId, int $quantity): void
    {
        $stock = WarehouseProduct::where(
            'warehouse_id',
            $warehouseId
        )->where('product_id',$productId)->firstOrFail();

        if ($stock->stock < $quantity) {
            throw new \Exception(
                'Insufficient warehouse stock.'
            );
        }

        $stock->decrement('stock',$quantity);
    }
}