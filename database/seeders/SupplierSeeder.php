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
            ['name' => 'Tech Supplier Co', 'company' => 'Tech Ltd', 'phone' => '03001230001', 'address' => 'Karachi', 'status' => 1],
            ['name' => 'Fashion Hub', 'company' => 'Style Pvt Ltd', 'phone' => '03001230002', 'address' => 'Lahore', 'status' => 1],
            ['name' => 'Food Supply Chain', 'company' => 'Fresh Foods', 'phone' => '03001230003', 'address' => 'Islamabad', 'status' => 1],
        ];

        foreach ($suppliers as $s) {
            Supplier::create($s);
        }
    }
}
