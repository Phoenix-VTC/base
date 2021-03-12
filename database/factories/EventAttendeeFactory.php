<?php

namespace Database\Factories;

use App\Enums\Attending;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventAttendeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventAttendee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'event_id' => Event::factory()->create()->id,
            'attending' => Attending::getRandomValue(),
        ];
    }
}
