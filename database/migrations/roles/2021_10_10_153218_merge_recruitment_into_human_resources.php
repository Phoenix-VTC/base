<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::where('name', 'recruitment')
            ->firstOrFail()
            ->delete();

        $humanResources = Role::findByName('human resources');
        $humanResources->givePermissionTo('handle driver applications');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Role::create(['name' => 'recruitment']);

        $humanResources = Role::findByName('human resources');
        $humanResources->revokePermissionTo('handle driver applications');
    }
};
