<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['name' => 'Ahmed Raza', 'email' => 'ahmed@gmail.com', 'phone' => '03001234567', 'address' => 'Karachi', 'status' => 1],
            ['name' => 'Ali Khan', 'email' => 'ali@gmail.com', 'phone' => '03111234567', 'address' => 'Lahore', 'status' => 1],
            ['name' => 'Sara Ahmed', 'email' => 'sara@gmail.com', 'phone' => '03211234567', 'address' => 'Islamabad', 'status' => 0],
        ];

        foreach ($customers as $c) {
            Customer::create($c);
        }
    }
}
