<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Warehouse;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $warehouseIds = Warehouse::pluck('id')->toArray();

        foreach (range(1, 30) as $i) {

            $supplier = Supplier::create([
                'name' => $faker->name(),
                'company' => $faker->company(),
                'phone' => '03' . rand(100000000, 999999999),
                'address' => $faker->city(),
                'status' => rand(0, 1),
            ]);

            if (!empty($warehouseIds)) {

                $randomWarehouses = collect($warehouseIds)
                    ->shuffle()
                    ->take(rand(1, min(3, count($warehouseIds))))
                    ->toArray();

                $supplier->warehouses()
                    ->attach($randomWarehouses);
            }
        }
    }
}