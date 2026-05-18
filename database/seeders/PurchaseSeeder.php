<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        foreach (range(1, 40) as $i) {

            $supplier = $suppliers->random();

            $purchase = Purchase::create([
                'invoice_no' => 'INV-' . rand(10000, 99999),

                'supplier_id' => $supplier->id,

                'purchase_date' => now()->subDays(rand(1, 60)),

                'total_amount' => 0,

                'note' => 'Dummy purchase data',

                'status' => 'approved',
            ]);

            $total = 0;

            // random 2 to 5 products
            foreach ($products->random(rand(2, 5)) as $product) {

                $qty = rand(1, 20);

                $price = rand(500, 5000);

                $subtotal = $qty * $price;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,

                    'product_id' => $product->id,

                    'quantity' => $qty,

                    'purchase_price' => $price,

                    'subtotal' => $subtotal,
                ]);

                // update stock
                $product->stock += $qty;
                $product->save();

                $total += $subtotal;
            }

            $purchase->update([
                'total_amount' => $total
            ]);
        }
    }
}