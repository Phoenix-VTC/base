<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestedByColumnToGameDataTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->foreignId('requested_by')
                ->after('approved')
                ->nullable()
                ->constrained('users');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->foreignId('requested_by')
                ->after('approved')
                ->nullable()
                ->constrained('users');
        });

        Schema::table('cargos', function (Blueprint $table) {
            $table->foreignId('requested_by')
                ->after('approved')
                ->nullable()
                ->constrained('users');
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
            $table->dropColumn('requested_by');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('requested_by');
        });

        Schema::table('cargos', function (Blueprint $table) {
            $table->dropColumn('requested_by');
        });
    }
}
