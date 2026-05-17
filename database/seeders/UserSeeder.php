<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@pos.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles(['Admin']);

        $manager = User::firstOrCreate(
            ['email' => 'manager@pos.test'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
            ]
        );
        $manager->syncRoles(['Manager']);

        $cashier = User::firstOrCreate(
            ['email' => 'cashier@pos.test'],
            [
                'name' => 'Cashier User',
                'password' => Hash::make('password'),
            ]
        );
        $cashier->syncRoles(['Cashier']);

        $legacy = User::where('email', 'arahmed212214@gmail.com')->first();
        if ($legacy) {
            $legacy->syncRoles(['Admin']);
        }
    }
}
