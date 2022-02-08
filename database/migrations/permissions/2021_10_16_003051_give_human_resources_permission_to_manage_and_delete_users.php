<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $humanResources = Role::findByName('human resources');
        $humanResources->givePermissionTo('manage users');
        $humanResources->givePermissionTo('delete users');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $humanResources = Role::findByName('human resources');
        $humanResources->revokePermissionTo('manage users');
        $humanResources->revokePermissionTo('delete users');
    }
};
