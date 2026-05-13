<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Tech Supplier Co',
                'company' => 'Tech Ltd',
                'phone' => '03001230001',
                'address' => 'Karachi',
                'status' => 1,
            ],
            [
                'name' => 'Fashion Hub',
                'company' => 'Style Pvt Ltd',
                'phone' => '03001230002',
                'address' => 'Lahore',
                'status' => 1,
            ],
            [
                'name' => 'Food Supply Chain',
                'company' => 'Fresh Foods',
                'phone' => '03001230003',
                'address' => 'Islamabad',
                'status' => 0,
            ],
            [
                'name' => 'Mobile Zone Traders',
                'company' => 'MZT Electronics',
                'phone' => '03001230004',
                'address' => 'Faisalabad',
                'status' => 1,
            ],
            [
                'name' => 'Global Stationers',
                'company' => 'GS Traders',
                'phone' => '03001230005',
                'address' => 'Rawalpindi',
                'status' => 0,
            ],
            [
                'name' => 'Smart Home Suppliers',
                'company' => 'HomeTech Pvt Ltd',
                'phone' => '03001230006',
                'address' => 'Multan',
                'status' => 1,
            ],
            [
                'name' => 'Fresh Mart Distribution',
                'company' => 'Fresh Mart',
                'phone' => '03001230007',
                'address' => 'Hyderabad',
                'status' => 1,
            ],
            [
                'name' => 'Book World Suppliers',
                'company' => 'Book World',
                'phone' => '03001230008',
                'address' => 'Peshawar',
                'status' => 0,
            ],
            [
                'name' => 'Industrial Equipments',
                'company' => 'IE Solutions',
                'phone' => '03001230009',
                'address' => 'Quetta',
                'status' => 1,
            ],
            [
                'name' => 'Kitchen Essentials',
                'company' => 'Kitchen Pro',
                'phone' => '03001230010',
                'address' => 'Sialkot',
                'status' => 0,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
