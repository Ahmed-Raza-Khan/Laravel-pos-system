<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::take(5)->get();
        $products = Product::take(10)->get();

        foreach (range(1, 10) as $i) {
            $supplier = $suppliers->random();
            
            $purchase = Purchase::create([
                'invoice_no' => 'INV-100' . $i,
                'supplier_id' => $supplier->id,
                'purchase_date' => now()->subDays(rand(1, 30)),
                'total_amount' => 0,
                'note' => 'Dummy purchase data',
                'status' => 1,
            ]);

            $total = 0;

            foreach ($products->random(3) as $product) {
                $qty = rand(1, 10);
                $price = rand(100, 1000);
                $subtotal = $qty * $price;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'purchase_price' => $price,
                    'subtotal' => $subtotal,
                ]);

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
