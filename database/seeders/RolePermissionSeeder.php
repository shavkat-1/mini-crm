<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Роли
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);

        // Права
        $permissions = [
            'view tickets',
            'update ticket status',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Назначение прав
        $admin->givePermissionTo(Permission::all());

        $manager->givePermissionTo([
            'view tickets',
            'update ticket status',
        ]);
    }
}
