<?php

namespace App\Console\Commands;

use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Console\Command;

class SeedPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the permissions and roles';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $seeder = new RolesAndPermissionsSeeder();
        $seeder->run();

        $this->info('Roles and permissions seeded successfully.');
    }
}
