<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorFieldToRolesTable extends Migration
{
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('badge_color')->default('#f4f5f7')->after('name');
            $table->string('text_color')->default('#1f2937')->after('badge_color');
        });
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('badge_color');
            $table->dropColumn('text_color');
        });
    }
}
