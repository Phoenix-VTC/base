<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('hosted_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('featured_image_url');
            $table->string('map_image_url')->nullable();
            $table->text('description');
            $table->string('server')->nullable();
            $table->string('required_dlcs')->nullable();
            $table->string('departure_location')->nullable();
            $table->string('arrival_location')->nullable();
            $table->dateTime('start_date');
            $table->integer('distance')->nullable();
            $table->integer('game_id')->nullable();
            $table->bigInteger('tmp_event_id')->nullable();
            $table->boolean('published')->default(false);
            $table->boolean('featured')->default(false);
            $table->boolean('external_event')->default(false);
            $table->boolean('public_event')->default(false);
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
        Schema::dropIfExists('events');
    }
};
