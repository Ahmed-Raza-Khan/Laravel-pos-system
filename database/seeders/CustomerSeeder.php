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
            [
                'name' => 'Ahmed Raza',
                'email' => 'ahmed@gmail.com',
                'phone' => '03001234567',
                'address' => 'Karachi',
                'status' => 1
            ],
            [
                'name' => 'Ali Khan',
                'email' => 'ali@gmail.com',
                'phone' => '03111234567',
                'address' => 'Lahore',
                'status' => 1
            ],
            [
                'name' => 'Sara Ahmed',
                'email' => 'sara@gmail.com',
                'phone' => '03211234567',
                'address' => 'Islamabad',
                'status' => 0
            ],
            [
                'name' => 'Hamza Tariq',
                'email' => 'hamza@gmail.com',
                'phone' => '03331234567',
                'address' => 'Faisalabad',
                'status' => 1
            ],
            [
                'name' => 'Ayesha Noor',
                'email' => 'ayesha@gmail.com',
                'phone' => '03451234567',
                'address' => 'Multan',
                'status' => 1
            ],
            [
                'name' => 'Usman Ali',
                'email' => 'usman@gmail.com',
                'phone' => '03099887766',
                'address' => 'Peshawar',
                'status' => 0
            ],
            [
                'name' => 'Fatima Khan',
                'email' => 'fatima@gmail.com',
                'phone' => '03122334455',
                'address' => 'Quetta',
                'status' => 1
            ],
            [
                'name' => 'Bilal Ahmed',
                'email' => 'bilal@gmail.com',
                'phone' => '03299887766',
                'address' => 'Hyderabad',
                'status' => 1
            ],
            [
                'name' => 'Zain Malik',
                'email' => 'zain@gmail.com',
                'phone' => '03344556677',
                'address' => 'Sialkot',
                'status' => 0
            ],
            [
                'name' => 'Hina Sheikh',
                'email' => 'hina@gmail.com',
                'phone' => '03466778899',
                'address' => 'Rawalpindi',
                'status' => 1
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
