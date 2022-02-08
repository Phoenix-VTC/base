<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Role::where('name', 'executive committee')
            ->firstOrFail()
            ->update(['name' => 'management']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Role::where('name', 'management')
            ->firstOrFail()
            ->update(['name' => 'executive committee']);
    }
};
