<?php

namespace App\Services;

use App\Models\Product;
use App\Models\InventoryHistory;

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
}