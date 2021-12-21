<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

class RenameManagementHumanResourcesEventsMediaAndModdingRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::query()
            ->where('name', 'management')
            ->update([
                'name' => 'manager',
            ]);

        Role::query()
            ->where('name', 'human resources')
            ->update([
                'name' => 'human resources team',
            ]);

        Role::query()
            ->where('name', 'events')
            ->update([
                'name' => 'event team',
            ]);

        Role::query()
            ->where('name', 'media')
            ->update([
                'name' => 'media team',
            ]);

        Role::query()
            ->where('name', 'modding')
            ->update([
                'name' => 'modding team',
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Role::query()
            ->where('name', 'manager')
            ->update([
                'name' => 'management',
            ]);

        Role::query()
            ->where('name', 'human resources team')
            ->update([
                'name' => 'human resources',
            ]);

        Role::query()
            ->where('name', 'event team')
            ->update([
                'name' => 'events',
            ]);

        Role::query()
            ->where('name', 'media team')
            ->update([
                'name' => 'media',
            ]);

        Role::query()
            ->where('name', 'modding team')
            ->update([
                'name' => 'modding',
            ]);
    }
}
