<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\PurchaseItem;
use App\Models\WarehouseProduct;
use App\Models\InventoryHistory;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $warehouses = Warehouse::all();

        foreach (range(1, 40) as $i) {

            $supplier = $suppliers->random();
            $warehouse = $supplier
                ->warehouses()
                ->inRandomOrder()
                ->first();

            if (!$warehouse) {
                continue;
            }

            $purchase = Purchase::create([
                'invoice_no'    => 'PUR-' . rand(10000,99999),
                'supplier_id'   => $supplier->id,
                'warehouse_id'  => $warehouse->id,
                'purchase_date' => now()->subDays(rand(1,60)),
                'total_amount'  => 0,
                'note'          => 'Dummy purchase',
                'status'        => 'approved',
            ]);

            $total = 0;

            foreach ($products->random(rand(2,5)) as $product) {

                $qty = rand(1,20);
                $price = rand(500,5000);
                $subtotal = $qty * $price;

                PurchaseItem::create([
                    'purchase_id'     => $purchase->id,
                    'product_id'      => $product->id,
                    'quantity'        => $qty,
                    'purchase_price'  => $price,
                    'subtotal'        => $subtotal,
                ]);

                $warehouseStock = WarehouseProduct::firstOrCreate(
                    [
                        'warehouse_id' => $warehouse->id,
                        'product_id'   => $product->id,
                    ],
                    [
                        'stock' => 0,
                    ]
                );

                $beforeStock = $warehouseStock->stock;
                $warehouseStock->increment('stock', $qty);
                $warehouseStock->refresh();

                InventoryHistory::create([
                    'product_id'     => $product->id,
                    'warehouse_id'   => $warehouse->id,
                    'type'           => 'purchase',
                    'quantity'       => $qty,
                    'stock_before'   => $beforeStock,
                    'stock_after'    => $warehouseStock->stock,
                    'notes'          => 'Stock added from seeded purchase ' . $purchase->invoice_no,
                    'created_by'     => 1,
                ]);

                $total += $subtotal;
            }

            $purchase->update([
                'total_amount' => $total
            ]);
        }
    }
}