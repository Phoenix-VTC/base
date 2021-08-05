<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedColumnToGameDataTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->boolean('approved')
                ->after('z')
                ->default(true);
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('approved')
                ->after('game_id')
                ->default(true);
        });

        Schema::table('cargos', function (Blueprint $table) {
            $table->boolean('approved')
                ->after('world_of_trucks')
                ->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('approved');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('approved');
        });

        Schema::table('cargos', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
    }
}
