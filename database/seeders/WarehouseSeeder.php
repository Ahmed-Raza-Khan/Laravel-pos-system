<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        Warehouse::insert([
            [
                'name' => 'Main Warehouse',
                'code' => 'WH-001',
                'phone' => '03001234567',
                'address' => 'Karachi',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lahore Warehouse',
                'code' => 'WH-002',
                'phone' => '03001234568',
                'address' => 'Lahore',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Karachi Warehouse',
                'code' => 'WH-003',
                'phone' => '03001234569',
                'address' => 'Karachi',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}