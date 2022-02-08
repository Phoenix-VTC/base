<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        if (random_int(0, 1) === 1) {
            $category = $this->faker->word();
        }

        if (random_int(0, 1) === 1) {
            $specialization = $this->faker->sentence();
        }

        if (random_int(0, 1) === 1) {
            $dlc = $this->faker->word();
        }

        if (random_int(0, 1) === 1) {
            $mod = $this->faker->word();
        }

        return [
            'name' => $this->faker->domainWord(),
            'category' => $category ?? null,
            'specialization' => $specialization ?? null,
            'dlc' => $dlc ?? null,
            'mod' => $mod ?? null,
            'game_id' => random_int(1, 2),
        ];
    }
}
