<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SaleItem;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $customers = Customer::all();

        if ($products->count() == 0) {
            $this->command->error('No products found. Please seed products first.');
            return;
        }

        for ($i = 1; $i <= 30; $i++) {

            $subtotal = 0;
            $discountAmount = rand(0, 500);
            $taxPercentage = 5;

            $sale = Sale::create([
                'invoice_no'      => 'INV-' . now()->format('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'customer_id'     => $customers->random()?->id,
                'subtotal'        => 0,
                'discount_type'   => 'fixed',
                'discount_value'  => $discountAmount,
                'discount_amount' => $discountAmount,
                'tax_percentage'  => $taxPercentage,
                'tax_amount'      => 0,
                'grand_total'     => 0,
                'paid_amount'     => 0,
                'due_amount'      => 0,
                'payment_method'  => collect([
                    'cash',
                    'card',
                    'bank_transfer',
                    'easypaisa',
                    'jazzcash'
                ])->random(),
                'sale_date'       => now()->subDays(rand(0, 30)),
                'created_by'      => 1,
                'notes'           => 'Dummy sale record',
            ]);

            $randomProducts = $products->random(rand(1, 5));

            foreach ($randomProducts as $product) {

                $qty = rand(1, 3);
                $price = $product->sale_price;
                $total = $qty * $price;

                SaleItem::create([
                    'sale_id'   => $sale->id,
                    'product_id'=> $product->id,
                    'quantity'  => $qty,
                    'price'     => $price,
                    'total'     => $total,
                ]);

                $subtotal += $total;
            }

            $afterDiscount = $subtotal - $discountAmount;

            $taxAmount = ($afterDiscount * $taxPercentage) / 100;

            $grandTotal = $afterDiscount + $taxAmount;

            $paidAmount = rand(
                (int) ($grandTotal / 2),
                (int) $grandTotal
            );

            $dueAmount = $grandTotal - $paidAmount;

            $sale->update([
                'subtotal'    => $subtotal,
                'tax_amount'  => $taxAmount,
                'grand_total' => $grandTotal,
                'paid_amount' => $paidAmount,
                'due_amount'  => $dueAmount,
            ]);
        }
    }
}
