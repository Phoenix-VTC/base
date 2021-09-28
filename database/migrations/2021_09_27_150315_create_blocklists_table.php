<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocklists', function (Blueprint $table) {
            $table->id();
            $table->json('usernames');
            $table->json('emails');
            $table->json('discord_ids');
            $table->json('truckersmp_ids');
            $table->json('steam_ids');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocklists');
    }
}
