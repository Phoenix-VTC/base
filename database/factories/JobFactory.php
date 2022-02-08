<?php

namespace Database\Factories;

use App\Enums\JobStatus;
use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        if (random_int(0, 1) === 1) {
            $comments = $this->faker->paragraph();
        }

        return [
            'user_id' => User::factory()->create()->id,
            'game_id' => random_int(1, 2),
            'pickup_city_id' => City::factory()->create()->id,
            'destination_city_id' => City::factory()->create()->id,
            'pickup_company_id' => Company::factory()->create()->id,
            'destination_company_id' => Company::factory()->create()->id,
            'cargo_id' => Cargo::factory()->create()->id,
            'started_at' => $this->faker->dateTime(),
            'finished_at' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '2 hours'),
            'distance' => random_int(1, 3000),
            'load_damage' => random_int(0, 100),
            'estimated_income' => random_int(500, 50000),
            'total_income' => random_int(500, 50000),
            'comments' => $comments ?? null,
            'status' => JobStatus::getRandomValue(),
        ];
    }
}
