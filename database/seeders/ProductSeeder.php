<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Electronics / Mobiles
            ['category_id' => 1, 'name' => 'iPhone 15 Pro Max', 'purchase_price' => 420000, 'sale_price' => 450000, 'stock' => 12],
            ['category_id' => 1, 'name' => 'Samsung Galaxy S24 Ultra', 'purchase_price' => 390000, 'sale_price' => 420000, 'stock' => 15],
            ['category_id' => 1, 'name' => 'Xiaomi Redmi Note 13', 'purchase_price' => 50000, 'sale_price' => 55000, 'stock' => 30],
            ['category_id' => 1, 'name' => 'Google Pixel 8 Pro', 'purchase_price' => 250000, 'sale_price' => 275000, 'stock' => 10],
            ['category_id' => 1, 'name' => 'OnePlus 12', 'purchase_price' => 180000, 'sale_price' => 200000, 'stock' => 14],
            ['category_id' => 1, 'name' => 'Realme GT Neo', 'purchase_price' => 85000, 'sale_price' => 95000, 'stock' => 18],
            ['category_id' => 1, 'name' => 'Infinix Zero Ultra', 'purchase_price' => 65000, 'sale_price' => 72000, 'stock' => 22],
            ['category_id' => 1, 'name' => 'Tecno Camon 30', 'purchase_price' => 58000, 'sale_price' => 65000, 'stock' => 25],
            ['category_id' => 1, 'name' => 'Vivo V30', 'purchase_price' => 120000, 'sale_price' => 132000, 'stock' => 16],
            ['category_id' => 1, 'name' => 'Oppo Reno 11', 'purchase_price' => 115000, 'sale_price' => 125000, 'stock' => 17],

            // Clothing
            ['category_id' => 2, 'name' => 'Men Black T-Shirt', 'purchase_price' => 1000, 'sale_price' => 1500, 'stock' => 50],
            ['category_id' => 2, 'name' => 'Women Hoodie', 'purchase_price' => 2500, 'sale_price' => 3500, 'stock' => 40],
            ['category_id' => 2, 'name' => 'Men Blue Jeans', 'purchase_price' => 2200, 'sale_price' => 3200, 'stock' => 35],
            ['category_id' => 2, 'name' => 'Women Summer Top', 'purchase_price' => 1200, 'sale_price' => 1800, 'stock' => 45],
            ['category_id' => 2, 'name' => 'Kids Printed Shirt', 'purchase_price' => 900, 'sale_price' => 1400, 'stock' => 38],
            ['category_id' => 2, 'name' => 'Men Formal Shirt', 'purchase_price' => 1800, 'sale_price' => 2600, 'stock' => 28],
            ['category_id' => 2, 'name' => 'Women Abaya', 'purchase_price' => 4000, 'sale_price' => 5500, 'stock' => 20],
            ['category_id' => 2, 'name' => 'Men Leather Jacket', 'purchase_price' => 7000, 'sale_price' => 9500, 'stock' => 12],
            ['category_id' => 2, 'name' => 'Sports Tracksuit', 'purchase_price' => 3500, 'sale_price' => 4800, 'stock' => 25],
            ['category_id' => 2, 'name' => 'Women Denim Jacket', 'purchase_price' => 4500, 'sale_price' => 6200, 'stock' => 14],

            // Books
            ['category_id' => 3, 'name' => 'Laravel Beginner Guide', 'purchase_price' => 2000, 'sale_price' => 3000, 'stock' => 20],
            ['category_id' => 3, 'name' => 'PHP Mastery', 'purchase_price' => 1800, 'sale_price' => 2700, 'stock' => 18],
            ['category_id' => 3, 'name' => 'JavaScript Deep Dive', 'purchase_price' => 2200, 'sale_price' => 3200, 'stock' => 15],
            ['category_id' => 3, 'name' => 'Clean Code', 'purchase_price' => 3000, 'sale_price' => 4200, 'stock' => 10],
            ['category_id' => 3, 'name' => 'Design Patterns', 'purchase_price' => 2800, 'sale_price' => 3900, 'stock' => 11],
            ['category_id' => 3, 'name' => 'Python Crash Course', 'purchase_price' => 2500, 'sale_price' => 3600, 'stock' => 16],
            ['category_id' => 3, 'name' => 'Database Design Basics', 'purchase_price' => 1700, 'sale_price' => 2500, 'stock' => 19],
            ['category_id' => 3, 'name' => 'Advanced Laravel APIs', 'purchase_price' => 3200, 'sale_price' => 4500, 'stock' => 9],
            ['category_id' => 3, 'name' => 'React for Beginners', 'purchase_price' => 2600, 'sale_price' => 3700, 'stock' => 13],
            ['category_id' => 3, 'name' => 'Software Engineering Principles', 'purchase_price' => 3500, 'sale_price' => 5000, 'stock' => 8],

            // Accessories
            ['category_id' => 1, 'name' => 'AirPods Pro', 'purchase_price' => 45000, 'sale_price' => 52000, 'stock' => 25],
            ['category_id' => 1, 'name' => 'Samsung Galaxy Buds', 'purchase_price' => 22000, 'sale_price' => 28000, 'stock' => 20],
            ['category_id' => 1, 'name' => 'Gaming Mouse RGB', 'purchase_price' => 2500, 'sale_price' => 4000, 'stock' => 35],
            ['category_id' => 1, 'name' => 'Mechanical Keyboard', 'purchase_price' => 6000, 'sale_price' => 8500, 'stock' => 18],
            ['category_id' => 1, 'name' => 'USB-C Fast Charger', 'purchase_price' => 1200, 'sale_price' => 2200, 'stock' => 50],
            ['category_id' => 1, 'name' => 'Portable SSD 1TB', 'purchase_price' => 18000, 'sale_price' => 23000, 'stock' => 12],
            ['category_id' => 1, 'name' => 'Smart Watch Series 9', 'purchase_price' => 38000, 'sale_price' => 45000, 'stock' => 15],
            ['category_id' => 1, 'name' => 'Bluetooth Speaker', 'purchase_price' => 5000, 'sale_price' => 7500, 'stock' => 26],
            ['category_id' => 1, 'name' => 'Laptop Cooling Pad', 'purchase_price' => 1800, 'sale_price' => 2800, 'stock' => 32],
            ['category_id' => 1, 'name' => 'Gaming Headset', 'purchase_price' => 4500, 'sale_price' => 6800, 'stock' => 21],
        ];

        $brandIds = Brand::pluck('id')->toArray();
        if (empty($brandIds)) {
            $brandIds = [null];
        }

        foreach ($products as $p) {
            Product::create([
                'category_id' => $p['category_id'],
                'brand_id' => $brandIds[array_rand($brandIds)],
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'sku' => 'SKU-' . rand(10000, 99999),
                'barcode' => 'BC-' . rand(1000000000, 9999999999),
                'purchase_price' => $p['purchase_price'],
                'sale_price' => $p['sale_price'],
                'stock' => $p['stock'],
                'image' => null,
                'description' => fake()->sentence(),
                'status' => 1,
            ]);
        }
    }
}
