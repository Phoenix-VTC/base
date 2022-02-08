<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        $developer = Role::findByName('developer');
        $developer->givePermissionTo('manage users');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $developer = Role::findByName('developer');
        $developer->revokePermissionTo('manage users');
    }
};
