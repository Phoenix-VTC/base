<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LinkMissingDataToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:link-missing-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add the missing application data to users';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        if (config('app.env') === 'production' && !$this->confirm('Are you SURE that you want to run this on a production environment?')) {
            $this->info('Command cancelled.');

            exit;
        }

        $this->info('Started linking data');

        $users = User::all();

        // Add missing Application IDs
        foreach ($users->whereNull('application_id') as $user) {
            try {
                $application = Application::where('username', $user->username)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                continue;
            }

            $user->application_id = $application->id;

            $user->save();

            $this->info('Application ID added to ' . $user->username);
        }

        // Add missing date of birth
        foreach ($users->whereNull('date_of_birth') as $user) {
            try {
                $application = Application::where('username', $user->username)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                continue;
            }

            $user->date_of_birth = $application->date_of_birth;

            $user->save();

            $this->info('Date of Birth added to ' . $user->username);
        }

        $this->info('Finished linking data');
    }
}
