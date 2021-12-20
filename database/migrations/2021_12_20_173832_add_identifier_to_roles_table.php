<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdentifierToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('identifier')->after('id')->nullable()->unique();
        });

        $this->updateRoles();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('identifier');
        });
    }

    private function updateRoles(): void
    {
        $roles = Role::all();

        foreach ($roles as $role) {
            $role->identifier = \Illuminate\Support\Str::snake($role->name);
            $role->save();
        }
    }
}
