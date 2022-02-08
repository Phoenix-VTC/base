<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = Permission::create(['name' => 'impersonate users']);

        $developer = Role::findByName('developer');
        $developer->givePermissionTo($permission);

        $management = Role::findByName('management');
        $management->givePermissionTo($permission);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'impersonate users')
            ->firstOrFail()
            ->delete();
    }
};
