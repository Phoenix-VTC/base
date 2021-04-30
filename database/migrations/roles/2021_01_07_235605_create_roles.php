<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => 'super admin']);

        Role::create(['name' => 'executive committee']);

        Role::create(['name' => 'human resources']);

        Role::create(['name' => 'recruitment']);

        Role::create(['name' => 'community interactions']);

        Role::create(['name' => 'events']);

        Role::create(['name' => 'media']);

        Role::create(['name' => 'modding']);

        Role::create(['name' => 'driver']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
}
