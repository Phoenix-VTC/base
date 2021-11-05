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
            $table->json('usernames')->nullable();
            $table->json('emails')->nullable();
            $table->json('discord_ids')->nullable();
            $table->json('truckersmp_ids')->nullable();
            $table->json('steam_ids')->nullable();
            $table->json('base_ids')->nullable();
            $table->longText('reason');
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
