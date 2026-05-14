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

            [
                'name' => 'Asus',
                'slug' => 'asus',
                'description' => 'Gaming and computer hardware',
                'status' => 1,
            ],

            [
                'name' => 'Acer',
                'slug' => 'acer',
                'description' => 'Laptop and electronics brand',
                'status' => 1,
            ],

            [
                'name' => 'Puma',
                'slug' => 'puma',
                'description' => 'Sportswear and footwear',
                'status' => 1,
            ],

            [
                'name' => 'Reebok',
                'slug' => 'reebok',
                'description' => 'Fitness and sports products',
                'status' => 0,
            ],

            [
                'name' => 'LG',
                'slug' => 'lg',
                'description' => 'Home appliances and electronics',
                'status' => 1,
            ],

            [
                'name' => 'Panasonic',
                'slug' => 'panasonic',
                'description' => 'Consumer electronics company',
                'status' => 1,
            ],

            [
                'name' => 'Canon',
                'slug' => 'canon',
                'description' => 'Camera and imaging products',
                'status' => 1,
            ],

            [
                'name' => 'Nikon',
                'slug' => 'nikon',
                'description' => 'Photography equipment manufacturer',
                'status' => 0,
            ],

            [
                'name' => 'Microsoft',
                'slug' => 'microsoft',
                'description' => 'Software and technology company',
                'status' => 1,
            ],

            [
                'name' => 'Intel',
                'slug' => 'intel',
                'description' => 'Processor manufacturing company',
                'status' => 1,
            ],

            [
                'name' => 'AMD',
                'slug' => 'amd',
                'description' => 'Computer processors and GPUs',
                'status' => 1,
            ],

            [
                'name' => 'Huawei',
                'slug' => 'huawei',
                'description' => 'Mobile and networking company',
                'status' => 0,
            ],

            [
                'name' => 'Xiaomi',
                'slug' => 'xiaomi',
                'description' => 'Affordable smart devices',
                'status' => 1,
            ],

            [
                'name' => 'Oppo',
                'slug' => 'oppo',
                'description' => 'Smartphone manufacturer',
                'status' => 1,
            ],

            [
                'name' => 'Vivo',
                'slug' => 'vivo',
                'description' => 'Mobile technology company',
                'status' => 1,
            ],

            [
                'name' => 'OnePlus',
                'slug' => 'oneplus',
                'description' => 'Premium Android smartphones',
                'status' => 1,
            ],

            [
                'name' => 'Realme',
                'slug' => 'realme',
                'description' => 'Budget smartphone brand',
                'status' => 0,
            ],

            [
                'name' => 'Gucci',
                'slug' => 'gucci',
                'description' => 'Luxury fashion brand',
                'status' => 1,
            ],

            [
                'name' => 'Zara',
                'slug' => 'zara',
                'description' => 'Fashion retail company',
                'status' => 1,
            ],

            [
                'name' => 'H&M',
                'slug' => 'hm',
                'description' => 'Clothing and accessories retailer',
                'status' => 1,
            ],

            [
                'name' => 'Rolex',
                'slug' => 'rolex',
                'description' => 'Luxury watch manufacturer',
                'status' => 0,
            ],

            [
                'name' => 'Casio',
                'slug' => 'casio',
                'description' => 'Digital watches and calculators',
                'status' => 1,
            ],

            [
                'name' => 'Toyota',
                'slug' => 'toyota',
                'description' => 'Automobile manufacturer',
                'status' => 1,
            ],

            [
                'name' => 'Honda',
                'slug' => 'honda',
                'description' => 'Cars and motorcycles company',
                'status' => 1,
            ],

            [
                'name' => 'BMW',
                'slug' => 'bmw',
                'description' => 'Luxury vehicle manufacturer',
                'status' => 1,
            ],

            [
                'name' => 'Mercedes',
                'slug' => 'mercedes',
                'description' => 'Premium car brand',
                'status' => 0,
            ],

            [
                'name' => 'Audi',
                'slug' => 'audi',
                'description' => 'German automobile company',
                'status' => 1,
            ],

            [
                'name' => 'Pepsi',
                'slug' => 'pepsi',
                'description' => 'Soft drinks brand',
                'status' => 1,
            ],

            [
                'name' => 'Coca Cola',
                'slug' => 'coca-cola',
                'description' => 'Beverage company',
                'status' => 1,
            ],

            [
                'name' => 'Nestle',
                'slug' => 'nestle',
                'description' => 'Food and beverage company',
                'status' => 1,
            ],

            [
                'name' => 'Unilever',
                'slug' => 'unilever',
                'description' => 'Consumer goods company',
                'status' => 0,
            ],

            [
                'name' => 'Loreal',
                'slug' => 'loreal',
                'description' => 'Beauty and cosmetics brand',
                'status' => 1,
            ],

            [
                'name' => 'Maybelline',
                'slug' => 'maybelline',
                'description' => 'Makeup and beauty products',
                'status' => 1,
            ],

        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
