<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        $manage_events = Permission::create(['name' => 'manage events']);

        $events = Role::findByName('events');
        $events->givePermissionTo($manage_events);

        $community_interactions = Role::findByName('community interactions');
        $community_interactions->givePermissionTo('manage events');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
