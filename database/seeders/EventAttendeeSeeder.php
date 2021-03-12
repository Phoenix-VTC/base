<?php

namespace Database\Seeders;

use App\Models\EventAttendee;
use Illuminate\Database\Seeder;

class EventAttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        EventAttendee::factory(10)->create();
    }
}
