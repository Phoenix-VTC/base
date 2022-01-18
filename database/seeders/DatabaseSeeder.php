<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ApplicationSeeder::class,
            EventSeeder::class,
            EventAttendeeSeeder::class,
            CitySeeder::class,
            CargoSeeder::class,
            CompanySeeder::class,
            JobSeeder::class,
            BlocklistSeeder::class,
            RolesAndPermissionsSeeder::class
        ]);
    }
}
