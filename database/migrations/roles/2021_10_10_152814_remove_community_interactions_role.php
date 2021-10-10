<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

class RemoveCommunityInteractionsRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::where('name', 'community interactions')
            ->firstOrFail()
            ->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Role::create(['name' => 'community interactions']);
    }
}
