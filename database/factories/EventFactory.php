<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'hosted_by' => User::factory()->create()->id,
            'featured_image_url' => 'https://via.placeholder.com/1080x720/18181B/FFFFFF?text=Phoenix+Events',
            'map_image_url' => 'https://via.placeholder.com/1080x720/18181B/FFFFFF?text=Phoenix+Events',
            'description' => $this->faker->paragraphs(5, true),
            'server' => 'Simulation '.random_int(1, 3),
            'required_dlcs' => $this->faker->words(3, true),
            'departure_location' => $this->faker->word(),
            'arrival_location' => $this->faker->word(),
            'start_date' => $this->faker->dateTimeBetween('+1 day', '+2 week'),
            'distance' => random_int(1000, 2000),
            'game_id' => random_int(1, 2),
            'published' => random_int(0, 1),
            'featured' => random_int(0, 1),
            'external_event' => random_int(0, 1),
            'public_event' => random_int(0, 1),
            'points' => random_int(100, 500),
        ];
    }
}
