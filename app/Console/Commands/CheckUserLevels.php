<?php

namespace App\Console\Commands;

use App\Jobs\CheckUserLevel;
use App\Models\User;
use Illuminate\Console\Command;

class CheckUserLevels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:check-levels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch a CheckUserLevel job for every user';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            CheckUserLevel::dispatch($user, false);
        }

        $this->info('All level check jobs have been dispatched.');
    }
}
