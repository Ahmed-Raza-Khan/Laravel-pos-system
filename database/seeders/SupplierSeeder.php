<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 30) as $i) {

            Supplier::create([
                'name' => $faker->name(),
                'company' => $faker->company(),
                'phone' => '03' . rand(100000000, 999999999),
                'address' => $faker->city(),
                'status' => rand(0, 1),
            ]);
        }
    }
}