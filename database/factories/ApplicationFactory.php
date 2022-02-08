<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        $steamData = [
            "avatar" => $this->faker->imageUrl(),
            "realname" => $this->faker->name,
            "loccityid" => random_int(1, 99999),
            "steamID64" => random_int(1000000, 10000000000000000),
            "avatarfull" => $this->faker->imageUrl(),
            "avatarhash" => $this->faker->md5,
            "lastlogoff" => $this->faker->unixTime,
            "profileurl" => "https://steamcommunity.com/id/" . $this->faker->userName,
            "personaname" => $this->faker->userName,
            "timecreated" => $this->faker->unixTime,
            "avatarmedium" => $this->faker->imageUrl(),
            "locstatecode" => random_int(0, 10),
            "personastate" => random_int(0, 6),
            "profilestate" => 1,
            "primaryclanid" => random_int(1000000, 10000000000000000),
            "loccountrycode" => $this->faker->countryCode,
            "personastateflags" => 0,
            "communityvisibilitystate" => 3,
        ];

        $application_answers = [];
        foreach (__('driver-application.additional_questions') as $question) {
            $answer = $this->faker->realText();

            $application_answers[$question] = $answer;
        }

        return [
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'discord_username' => "{$this->faker->userName}#" . random_int(0001, 9999),
            'date_of_birth' => $this->faker->date(),
            'country' => $this->faker->countryCode,
            'steam_data' => $steamData,
            'truckersmp_id' => 3181778,
            'application_answers' => json_encode($application_answers, JSON_THROW_ON_ERROR),
        ];
    }
}
