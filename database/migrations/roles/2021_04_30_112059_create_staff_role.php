<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

class CreateStaffRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Role::create(['name' => 'phoenix staff']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Role::where('name', 'phoenix staff')
            ->firstOrFail()
            ->delete();
    }
}
