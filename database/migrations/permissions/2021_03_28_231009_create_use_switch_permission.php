<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateUseSwitchPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $use_switch = Permission::create(['name' => 'use switch']);

        $beta_tester = Role::findByName('beta tester');
        $beta_tester->givePermissionTo($use_switch);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Permission::where('name', 'use switch')
            ->firstOrFail()
            ->delete();
    }
}
