<?php

namespace Database\Factories;

use App\Models\City;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        if (random_int(0, 1) === 1) {
            $dlc = $this->faker->word();
        }

        if (random_int(0, 1) === 1) {
            $mod = $this->faker->word();
        }

        return [
            'real_name' => $this->faker->word(),
            'name' => $this->faker->word(),
            'country' => $this->faker->word(),
            'dlc' => $dlc ?? null,
            'mod' => $mod ?? null,
            'game_id' => random_int(1, 2),
        ];
    }
}
