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
    public function up(): void
    {
        $viewBlocklist = Permission::create(['name' => 'view blocklist']);
        $createBlocklist = Permission::create(['name' => 'create blocklist']);
        $deleteBlocklist = Permission::create(['name' => 'delete blocklist']);

        $management = Role::findByName('management');
        $management->givePermissionTo([
            $viewBlocklist,
            $createBlocklist,
            $deleteBlocklist,
        ]);

        $humanResources = Role::findByName('human resources');
        $humanResources->givePermissionTo([
            $viewBlocklist,
            $createBlocklist,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Permission::query()
            ->where('name', 'view blocklist')
            ->firstOrFail()
            ->delete();

        Permission::query()
            ->where('name', 'create blocklist')
            ->firstOrFail()
            ->delete();

        Permission::query()
            ->where('name', 'delete blocklist')
            ->firstOrFail()
            ->delete();
    }
};
