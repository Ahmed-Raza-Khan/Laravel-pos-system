<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [

            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'description' => 'Electronics and mobile brand',
                'status' => 1,
            ],

            [
                'name' => 'Apple',
                'slug' => 'apple',
                'description' => 'Premium tech products',
                'status' => 1,
            ],

            [
                'name' => 'Nike',
                'slug' => 'nike',
                'description' => 'Sportswear brand',
                'status' => 1,
            ],

            [
                'name' => 'Adidas',
                'slug' => 'adidas',
                'description' => 'Sports clothing and shoes',
                'status' => 0,
            ],

            [
                'name' => 'Dell',
                'slug' => 'dell',
                'description' => 'Computer manufacturer',
                'status' => 1,
            ],

            [
                'name' => 'HP',
                'slug' => 'hp',
                'description' => 'Laptop and printer brand',
                'status' => 1,
            ],

            [
                'name' => 'Lenovo',
                'slug' => 'lenovo',
                'description' => 'Technology company',
                'status' => 0,
            ],

            [
                'name' => 'Sony',
                'slug' => 'sony',
                'description' => 'Entertainment and electronics',
                'status' => 1,
            ],

        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
