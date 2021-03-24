<?php

use App\Enums\JobStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->integer('game_id');
            $table->foreignId('pickup_city_id')
                ->constrained('cities')
                ->cascadeOnUpdate();
            $table->foreignId('destination_city_id')
                ->constrained('cities')
                ->cascadeOnUpdate();
            $table->foreignId('pickup_company_id')
                ->constrained('companies')
                ->cascadeOnUpdate();
            $table->foreignId('destination_company_id')
                ->constrained('companies')
                ->cascadeOnUpdate();
            $table->foreignId('cargo_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at');
            $table->integer('distance');
            $table->integer('load_damage');
            $table->integer('estimated_income');
            $table->integer('total_income');
            $table->text('comments')->nullable();
            $table->integer('status')->default(JobStatus::Incomplete);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
