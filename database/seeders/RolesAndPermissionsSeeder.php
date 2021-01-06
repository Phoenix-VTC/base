<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'handle driver applications']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'delete users']);

        // Create roles and assign created permissions
        Role::create(['name' => 'super admin']);

        Role::create(['name' => 'executive committee'])
            ->givePermissionTo(['handle driver applications', 'manage users', 'delete users']);

        Role::create(['name' => 'human resources'])
            ->givePermissionTo(['handle driver applications', 'manage users', 'delete users']);

        Role::create(['name' => 'recruitment'])
            ->givePermissionTo(['handle driver applications', 'manage users']);

        Role::create(['name' => 'community interactions'])
            ->givePermissionTo(['manage users']);

        Role::create(['name' => 'events']);

        Role::create(['name' => 'media']);

        Role::create(['name' => 'modding']);

        Role::create(['name' => 'driver']);
    }
}
