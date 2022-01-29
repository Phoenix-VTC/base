<?php

namespace App\Console\Commands;

use App\Jobs\CheckUserLevel;
use App\Jobs\DepositInitialJobPoints;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class CheckUserLevels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:check-levels
                            {--deposit-initial-job-xp : Whether every user should have their initial job XP calculated and rewarded (only if their Job XP wallet is empty)}';

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

        $depositInitialJobXp = $this->option('deposit-initial-job-xp');

        foreach ($users as $user) {
            // If $depositInitialJobXp is true, dispatch a DepositInitialJobPoints job for every user first
            if ($depositInitialJobXp) {
                Bus::chain([
                    new DepositInitialJobPoints($user),
                    new CheckUserLevel($user, false),
                ])->dispatch();
            } else {
                // Otherwise, only dispatch a CheckUserLevel job for every user
                CheckUserLevel::dispatch($user, false);
            }
        }

        $this->info('All level check jobs have been dispatched.');
    }
}
