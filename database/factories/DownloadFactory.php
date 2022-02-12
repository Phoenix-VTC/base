<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DownloadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(asText: true),
            'description' => $this->faker->paragraph(),
            'image_path' => $this->faker->filePath(),
            'file_path' => $this->faker->filePath(),
            'updated_by' => \App\Models\User::inRandomOrder()->first()->id,
        ];
    }
}
