<?php

namespace Database\Factories;

use App\Models\Blocklist;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlocklistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blocklist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition()
    {
        $usernames = [
            $this->faker->unique()->userName(),
            $this->faker->unique()->userName(),
            $this->faker->unique()->userName(),
            $this->faker->unique()->userName(),
        ];

        $emails = [
            $this->faker->unique()->email(),
            $this->faker->unique()->email(),
            $this->faker->unique()->email(),
            $this->faker->unique()->email(),
        ];

        $discord_ids = [
            random_int(100000000000000000, 999999999999999999),
            random_int(100000000000000000, 999999999999999999),
            random_int(100000000000000000, 999999999999999999),
            random_int(100000000000000000, 999999999999999999),
        ];

        $truckersmp_ids = [
            random_int(1000, 4000000),
            random_int(1000, 4000000),
            random_int(1000, 4000000),
            random_int(1000, 4000000),
        ];

        $steam_ids = [
            random_int(10000000000000000, 99999999999999999),
            random_int(10000000000000000, 99999999999999999),
            random_int(10000000000000000, 99999999999999999),
            random_int(10000000000000000, 99999999999999999),
        ];

        return [
            'usernames' => $usernames,
            'emails' => $emails,
            'discord_ids' => $discord_ids,
            'truckersmp_ids' => $truckersmp_ids,
            'steam_ids' => $steam_ids,
            'reason' => $this->faker->text(),
        ];
    }
}
