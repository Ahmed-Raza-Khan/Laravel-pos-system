<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public const PERMISSIONS = [
        'view dashboard',
        'manage sales',
        'manage products',
        'manage categories',
        'manage brands',
        'manage customers',
        'manage suppliers',
        'manage purchases',
        'manage inventory',
        'manage reports',
        'manage users',
    ];

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (self::PERMISSIONS as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $cashier = Role::firstOrCreate(['name' => 'Cashier']);

        $admin->syncPermissions(self::PERMISSIONS);

        $manager->syncPermissions([
            'view dashboard',
            'manage sales',
            'manage products',
            'manage categories',
            'manage brands',
            'manage customers',
            'manage suppliers',
            'manage purchases',
            'manage inventory',
            'manage reports',
        ]);

        $cashier->syncPermissions([
            'view dashboard',
            'manage sales',
            'manage customers',
        ]);
    }
}
