<?php

namespace App\Jobs;

use App\Actions\Wallet\FindOrCreateWallet;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DepositInitialJobPoints implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * This job generates the Job XP for a user based on their total job distance.
     * Since this job is only meant to run if the user does not have any Job XP yet, it completes the job if they do have any.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;

        // Find or create the user's Job XP wallet
        $wallet = (new FindOrCreateWallet())->execute($user, 'Job XP');

        // If the user already has Job XP, we don't need to calculate anything (see above).
        if ($wallet->balance > 0) {
            return;
        }

        // Get the user's total job distance.
        $total_distance = $user->jobs()->sum('distance');

        // Get the multiplier
        $multiplier = config('phoenix.job_xp_multiplier');

        // Calculate the Job XP
        $job_xp = $total_distance * $multiplier;

        // Add the XP to the Job XP wallet
        $wallet->deposit($job_xp, ['description' => 'Initial Job XP deposit']);
    }
}
