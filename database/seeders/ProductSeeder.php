<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['category_id' => 1, 'name' => 'iPhone 15 Pro Max', 'purchase_price' => 420000, 'sale_price' => 450000, 'stock' => 12],
            ['category_id' => 1, 'name' => 'Samsung Galaxy S24 Ultra', 'purchase_price' => 390000, 'sale_price' => 420000, 'stock' => 15],
            ['category_id' => 1, 'name' => 'Xiaomi Redmi Note 13', 'purchase_price' => 50000, 'sale_price' => 55000, 'stock' => 30],
            ['category_id' => 2, 'name' => 'Men Black T-Shirt', 'purchase_price' => 1000, 'sale_price' => 1500, 'stock' => 50],
            ['category_id' => 2, 'name' => 'Women Hoodie', 'purchase_price' => 2500, 'sale_price' => 3500, 'stock' => 40],
            ['category_id' => 3, 'name' => 'Laravel Beginner Guide', 'purchase_price' => 2000, 'sale_price' => 3000, 'stock' => 20],
        ];

        foreach ($products as $p) {
            Product::create([
                'category_id' => $p['category_id'],
                'brand_id' => null,

                'name' => $p['name'],
                'slug' => Str::slug($p['name']),

                'sku' => 'SKU-' . rand(10000, 99999),
                'barcode' => null,

                'purchase_price' => $p['purchase_price'],
                'sale_price' => $p['sale_price'],

                'stock' => $p['stock'],

                'image' => null,
                'description' => null,

                'status' => 1,
            ]);
        }
    }
}
