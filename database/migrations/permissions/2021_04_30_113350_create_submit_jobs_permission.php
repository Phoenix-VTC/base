<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateSubmitJobsPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $permission = Permission::create(['name' => 'submit jobs']);

        $beta_tester = Role::findByName('beta tester');
        $beta_tester->givePermissionTo($permission);

        $early_bird = Role::findByName('early bird');
        $early_bird->givePermissionTo($permission);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Permission::where('name', 'submit jobs')
            ->firstOrFail()
            ->delete();
    }
}
