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
            // 📱 Electronics
            ['category_id' => 1, 'name' => 'iPhone 15 Pro Max', 'price' => 450000, 'stock' => 12, 'status' => 1],
            ['category_id' => 1, 'name' => 'Samsung Galaxy S24 Ultra', 'price' => 420000, 'stock' => 15, 'status' => 1],
            ['category_id' => 1, 'name' => 'Xiaomi Redmi Note 13', 'price' => 55000, 'stock' => 30, 'status' => 1],
            ['category_id' => 1, 'name' => 'Dell Laptop XPS 13', 'price' => 320000, 'stock' => 8, 'status' => 1],
            ['category_id' => 1, 'name' => 'HP Pavilion Laptop', 'price' => 210000, 'stock' => 10, 'status' => 1],
            ['category_id' => 1, 'name' => 'Apple AirPods Pro', 'price' => 65000, 'stock' => 25, 'status' => 1],
            ['category_id' => 1, 'name' => 'Sony Headphones WH-1000XM5', 'price' => 85000, 'stock' => 18, 'status' => 1],
            ['category_id' => 1, 'name' => 'Samsung Smart TV 55"', 'price' => 180000, 'stock' => 6, 'status' => 1],
            ['category_id' => 1, 'name' => 'iPad Air', 'price' => 220000, 'stock' => 10, 'status' => 1],
            ['category_id' => 1, 'name' => 'Canon DSLR Camera', 'price' => 150000, 'stock' => 7, 'status' => 1],

            // 👕 Clothing
            ['category_id' => 2, 'name' => 'Men Black T-Shirt', 'price' => 1500, 'stock' => 50, 'status' => 1],
            ['category_id' => 2, 'name' => 'Women Hoodie', 'price' => 3500, 'stock' => 40, 'status' => 1],
            ['category_id' => 2, 'name' => 'Blue Denim Jeans', 'price' => 4000, 'stock' => 35, 'status' => 1],
            ['category_id' => 2, 'name' => 'Winter Jacket', 'price' => 8000, 'stock' => 20, 'status' => 1],
            ['category_id' => 2, 'name' => 'Sports Tracksuit', 'price' => 5000, 'stock' => 25, 'status' => 1],
            ['category_id' => 2, 'name' => 'Formal Shirt White', 'price' => 2500, 'stock' => 45, 'status' => 1],
            ['category_id' => 2, 'name' => 'Sneakers Nike', 'price' => 12000, 'stock' => 15, 'status' => 1],
            ['category_id' => 2, 'name' => 'Adidas Running Shoes', 'price' => 11000, 'stock' => 18, 'status' => 1],

            // 📚 Books
            ['category_id' => 3, 'name' => 'Laravel Beginner Guide', 'price' => 3000, 'stock' => 20, 'status' => 1],
            ['category_id' => 3, 'name' => 'PHP Mastery Book', 'price' => 2800, 'stock' => 15, 'status' => 1],
            ['category_id' => 3, 'name' => 'JavaScript Handbook', 'price' => 3500, 'stock' => 18, 'status' => 1],
            ['category_id' => 3, 'name' => 'Clean Code Book', 'price' => 4000, 'stock' => 12, 'status' => 1],

            // 🍔 Food
            ['category_id' => 5, 'name' => 'Biryani Pack', 'price' => 350, 'stock' => 100, 'status' => 1],
            ['category_id' => 5, 'name' => 'Burger Combo', 'price' => 800, 'stock' => 60, 'status' => 1],
            ['category_id' => 5, 'name' => 'Pizza Large', 'price' => 1500, 'stock' => 30, 'status' => 1],
            ['category_id' => 5, 'name' => 'Cold Drink 1.5L', 'price' => 180, 'stock' => 120, 'status' => 1],

            // 🏃 Sports
            ['category_id' => 6, 'name' => 'Cricket Bat', 'price' => 5000, 'stock' => 25, 'status' => 1],
            ['category_id' => 6, 'name' => 'Football', 'price' => 2500, 'stock' => 40, 'status' => 1],
            ['category_id' => 6, 'name' => 'Gym Dumbbells Set', 'price' => 8000, 'stock' => 10, 'status' => 1],

            // 🧴 Beauty
            ['category_id' => 8, 'name' => 'Face Wash', 'price' => 600, 'stock' => 70, 'status' => 1],
            ['category_id' => 8, 'name' => 'Shampoo Bottle', 'price' => 700, 'stock' => 80, 'status' => 1],

            // 🚗 Automotive
            ['category_id' => 9, 'name' => 'Car Engine Oil', 'price' => 2500, 'stock' => 30, 'status' => 1],
            ['category_id' => 9, 'name' => 'Car Air Filter', 'price' => 1500, 'stock' => 25, 'status' => 1],

            // 💊 Health
            ['category_id' => 10, 'name' => 'Vitamin C Tablets', 'price' => 900, 'stock' => 60, 'status' => 1],
            ['category_id' => 10, 'name' => 'First Aid Kit', 'price' => 2000, 'stock' => 20, 'status' => 1],

            // ✏️ Stationery
            ['category_id' => 11, 'name' => 'Notebook Pack', 'price' => 500, 'stock' => 100, 'status' => 1],
            ['category_id' => 11, 'name' => 'Ball Pen Set', 'price' => 300, 'stock' => 150, 'status' => 1],

            // 🎮 Gaming
            ['category_id' => 12, 'name' => 'PlayStation 5', 'price' => 180000, 'stock' => 5, 'status' => 1],
            ['category_id' => 12, 'name' => 'Xbox Series X', 'price' => 175000, 'stock' => 6, 'status' => 1],
        ];

        foreach ($products as $p) {
            Product::create([
                'category_id' => $p['category_id'],
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'price' => $p['price'],
                'stock' => $p['stock'],
                'status' => $p['status'],
            ]);
        }
    }
}
