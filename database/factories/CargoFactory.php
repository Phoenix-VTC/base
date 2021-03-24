<?php

namespace Database\Factories;

use App\Models\Cargo;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class CargoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cargo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        if (random_int(0, 1) === 1) {
            $dlc = $this->faker->word;
        }

        if (random_int(0, 1) === 1) {
            $mod = $this->faker->word;
        }

        return [
            'name' => $this->faker->word,
            'dlc' => $dlc ?? null,
            'mod' => $mod ?? null,
            'weight' => random_int(0, 60),
            'game_id' => random_int(1, 2),
            'world_of_trucks' => (bool)random_int(0, 1),
        ];
    }
}
