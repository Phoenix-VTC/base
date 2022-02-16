<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

class GiveHumanResourcesPermissionToManageAndDeleteUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $humanResources = Role::query()
            ->where('name', 'human resources')
            ->orWhere('name', 'human resources team')
            ->first();
        $humanResources?->givePermissionTo('manage users');
        $humanResources?->givePermissionTo('delete users');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $humanResources = Role::query()
            ->where('name', 'human resources')
            ->orWhere('name', 'human resources team')
            ->first();
        $humanResources?->revokePermissionTo('manage users');
        $humanResources?->revokePermissionTo('delete users');
    }
}
