<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = Permission::create(['name' => 'manage driver inactivity']);

        $management = Role::findByName('management');
        $management->givePermissionTo($permission);

        $human_resources = Role::findByName('human resources');
        $human_resources->givePermissionTo($permission);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'manage driver inactivity')
            ->firstOrFail()
            ->delete();
    }
};
