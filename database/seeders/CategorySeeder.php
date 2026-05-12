<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'status' => 1],
            ['name' => 'Clothing', 'status' => 1],
            ['name' => 'Books', 'status' => 1],
            ['name' => 'Furniture', 'status' => 0],
            ['name' => 'Food & Beverages', 'status' => 1],
            ['name' => 'Sports', 'status' => 1],
            ['name' => 'Toys', 'status' => 0],
            ['name' => 'Beauty & Cosmetics', 'status' => 1],
            ['name' => 'Automotive', 'status' => 0],
            ['name' => 'Health & Fitness', 'status' => 1],
            ['name' => 'Stationery', 'status' => 1],
            ['name' => 'Gaming', 'status' => 0],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'status' => $category['status'],
            ]);
        }
    }
}
