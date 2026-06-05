<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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
            // Grocery
            ['category_id' => 4, 'name' => 'Basmati Rice 5kg', 'purchase_price' => 1800, 'sale_price' => 2200, 'stock' => 60],
            ['category_id' => 4, 'name' => 'Basmati Rice 10kg', 'purchase_price' => 3500, 'sale_price' => 4200, 'stock' => 40],
            ['category_id' => 4, 'name' => 'Sugar 1kg', 'purchase_price' => 130, 'sale_price' => 160, 'stock' => 200],
            ['category_id' => 4, 'name' => 'Flour 10kg', 'purchase_price' => 1200, 'sale_price' => 1450, 'stock' => 80],
            ['category_id' => 4, 'name' => 'Cooking Oil 5L', 'purchase_price' => 2500, 'sale_price' => 2950, 'stock' => 75],
            ['category_id' => 4, 'name' => 'Desi Ghee 1kg', 'purchase_price' => 850, 'sale_price' => 1100, 'stock' => 90],
            ['category_id' => 4, 'name' => 'Salt 800g', 'purchase_price' => 40, 'sale_price' => 60, 'stock' => 250],
            ['category_id' => 4, 'name' => 'Tea 900g', 'purchase_price' => 1450, 'sale_price' => 1800, 'stock' => 65],
            ['category_id' => 4, 'name' => 'Red Chili Powder', 'purchase_price' => 180, 'sale_price' => 250, 'stock' => 100],
            ['category_id' => 4, 'name' => 'Turmeric Powder', 'purchase_price' => 140, 'sale_price' => 210, 'stock' => 100],

            // Beverages
            ['category_id' => 5, 'name' => 'Coca Cola 1.5L', 'purchase_price' => 180, 'sale_price' => 250, 'stock' => 150],
            ['category_id' => 5, 'name' => 'Pepsi 1.5L', 'purchase_price' => 180, 'sale_price' => 250, 'stock' => 150],
            ['category_id' => 5, 'name' => '7UP 1.5L', 'purchase_price' => 180, 'sale_price' => 250, 'stock' => 150],
            ['category_id' => 5, 'name' => 'Sprite 1.5L', 'purchase_price' => 180, 'sale_price' => 250, 'stock' => 150],
            ['category_id' => 5, 'name' => 'Nestle Water 1.5L', 'purchase_price' => 60, 'sale_price' => 100, 'stock' => 300],
            ['category_id' => 5, 'name' => 'Pakola 1L', 'purchase_price' => 90, 'sale_price' => 140, 'stock' => 120],
            ['category_id' => 5, 'name' => 'Mango Juice', 'purchase_price' => 80, 'sale_price' => 130, 'stock' => 140],
            ['category_id' => 5, 'name' => 'Apple Juice', 'purchase_price' => 85, 'sale_price' => 140, 'stock' => 130],

            // Personal Care
            ['category_id' => 6, 'name' => 'Lux Soap', 'purchase_price' => 120, 'sale_price' => 180, 'stock' => 250],
            ['category_id' => 6, 'name' => 'Dove Soap', 'purchase_price' => 180, 'sale_price' => 260, 'stock' => 180],
            ['category_id' => 6, 'name' => 'Safeguard Soap', 'purchase_price' => 130, 'sale_price' => 190, 'stock' => 220],
            ['category_id' => 6, 'name' => 'Colgate Toothpaste', 'purchase_price' => 180, 'sale_price' => 280, 'stock' => 170],
            ['category_id' => 6, 'name' => 'Sensodyne Toothpaste', 'purchase_price' => 320, 'sale_price' => 450, 'stock' => 120],
            ['category_id' => 6, 'name' => 'Head & Shoulders Shampoo', 'purchase_price' => 450, 'sale_price' => 650, 'stock' => 100],
            ['category_id' => 6, 'name' => 'Sunsilk Shampoo', 'purchase_price' => 280, 'sale_price' => 420, 'stock' => 120],
            ['category_id' => 6, 'name' => 'Gillette Razor', 'purchase_price' => 180, 'sale_price' => 280, 'stock' => 90],

            // Household
            ['category_id' => 7, 'name' => 'Surf Excel 1kg', 'purchase_price' => 550, 'sale_price' => 750, 'stock' => 110],
            ['category_id' => 7, 'name' => 'Bonus Detergent', 'purchase_price' => 280, 'sale_price' => 420, 'stock' => 130],
            ['category_id' => 7, 'name' => 'Vim Bar', 'purchase_price' => 45, 'sale_price' => 80, 'stock' => 250],
            ['category_id' => 7, 'name' => 'Dish Wash Liquid', 'purchase_price' => 180, 'sale_price' => 290, 'stock' => 120],
            ['category_id' => 7, 'name' => 'Glass Cleaner', 'purchase_price' => 250, 'sale_price' => 380, 'stock' => 90],
            ['category_id' => 7, 'name' => 'Toilet Cleaner', 'purchase_price' => 210, 'sale_price' => 330, 'stock' => 95],

            // Baby Care
            ['category_id' => 8, 'name' => 'Pampers Jumbo Pack', 'purchase_price' => 1800, 'sale_price' => 2400, 'stock' => 80],
            ['category_id' => 8, 'name' => 'Canbebe Diapers', 'purchase_price' => 1400, 'sale_price' => 1900, 'stock' => 90],
            ['category_id' => 8, 'name' => 'Johnson Baby Powder', 'purchase_price' => 220, 'sale_price' => 340, 'stock' => 130],
            ['category_id' => 8, 'name' => 'Johnson Baby Oil', 'purchase_price' => 250, 'sale_price' => 380, 'stock' => 120],
            ['category_id' => 8, 'name' => 'Baby Wipes Pack', 'purchase_price' => 180, 'sale_price' => 290, 'stock' => 150],

            // Stationery
            ['category_id' => 9, 'name' => 'Dollar Ball Pen', 'purchase_price' => 20, 'sale_price' => 40, 'stock' => 500],
            ['category_id' => 9, 'name' => 'Piano Marker', 'purchase_price' => 50, 'sale_price' => 90, 'stock' => 300],
            ['category_id' => 9, 'name' => 'A4 Notebook', 'purchase_price' => 80, 'sale_price' => 150, 'stock' => 250],
            ['category_id' => 9, 'name' => 'Stapler', 'purchase_price' => 180, 'sale_price' => 320, 'stock' => 80],
            ['category_id' => 9, 'name' => 'Scientific Calculator', 'purchase_price' => 850, 'sale_price' => 1200, 'stock' => 40],

            // Home Appliances
            ['category_id' => 10, 'name' => 'Dawlance Refrigerator', 'purchase_price' => 85000, 'sale_price' => 98000, 'stock' => 12],
            ['category_id' => 10, 'name' => 'Haier Refrigerator', 'purchase_price' => 95000, 'sale_price' => 110000, 'stock' => 10],
            ['category_id' => 10, 'name' => 'PEL Deep Freezer', 'purchase_price' => 65000, 'sale_price' => 76000, 'stock' => 15],
            ['category_id' => 10, 'name' => 'Orient AC 1.5 Ton', 'purchase_price' => 120000, 'sale_price' => 140000, 'stock' => 8],
            ['category_id' => 10, 'name' => 'LED Smart TV 55 Inch', 'purchase_price' => 135000, 'sale_price' => 155000, 'stock' => 10],

            // Luxury
            ['category_id' => 11, 'name' => 'Rolex Submariner', 'purchase_price' => 2500000, 'sale_price' => 3200000, 'stock' => 2],
            ['category_id' => 11, 'name' => 'Omega Speedmaster', 'purchase_price' => 1500000, 'sale_price' => 1900000, 'stock' => 3],
            ['category_id' => 11, 'name' => 'Louis Vuitton Wallet', 'purchase_price' => 180000, 'sale_price' => 240000, 'stock' => 5],
            ['category_id' => 11, 'name' => 'Gucci Belt', 'purchase_price' => 120000, 'sale_price' => 170000, 'stock' => 5],
            ['category_id' => 11, 'name' => 'Versace Perfume', 'purchase_price' => 45000, 'sale_price' => 65000, 'stock' => 8],
            
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
            $slug = Str::slug($p['name']);
            $sku = 'SKU-' . rand(10000, 99999);
            $barcode = 'BC-' . rand(1000000000, 9999999999);
            $imagePath = "products/{$slug}.svg";

            if (!Storage::disk('public')->exists($imagePath)) {
                $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="800" viewBox="0 0 800 800"><rect width="800" height="800" rx="48" fill="#eef2ff"/><rect x="48" y="48" width="704" height="704" rx="32" fill="rgba(59,130,246,0.08)"/><text x="50%" y="42%" dominant-baseline="middle" text-anchor="middle" font-family="Arial, sans-serif" font-size="48" fill="#0f172a">' . addslashes($p['name']) . '</text><text x="50%" y="58%" dominant-baseline="middle" text-anchor="middle" font-family="Arial, sans-serif" font-size="28" fill="#475569">SKU: ' . addslashes($sku) . '</text><text x="50%" y="68%" dominant-baseline="middle" text-anchor="middle" font-family="Arial, sans-serif" font-size="24" fill="#64748b">' . addslashes('Barcode: ' . $barcode) . '</text></svg>';
                Storage::disk('public')->put($imagePath, $svg);
            }

            Product::create([
                'category_id' => $p['category_id'],
                'brand_id' => $brandIds[array_rand($brandIds)],
                'name' => $p['name'],
                'slug' => $slug,
                'sku' => $sku,
                'barcode' => $barcode,
                'purchase_price' => $p['purchase_price'],
                'sale_price' => $p['sale_price'],
                'stock' => $p['stock'],
                'image' => $imagePath,
                'description' => fake()->sentence(),
                'status' => 1,
            ]);
        }
    }
}
