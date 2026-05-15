<?php

namespace App\Services;

use App\Models\Product;
use App\Models\InventoryHistory;

class InventoryService
{
    /**
     * Create Inventory History
     */
    public function log(
        Product $product,
        string $type,
        int $quantity,
        int $stockBefore,
        int $stockAfter,
        ?string $notes = null
    ) {

        InventoryHistory::create([
            'product_id'   => $product->id,
            'type'         => $type,
            'quantity'     => $quantity,
            'stock_before' => $stockBefore,
            'stock_after'  => $stockAfter,
            'notes'        => $notes,
            'created_by'   => auth()->id(),
        ]);
    }
}