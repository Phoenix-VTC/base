<?php

namespace App\Jobs\Jobs;

use App\Actions\Wallet\FindOrCreateWallet;
use App\Events\UserPointsChanged;
use App\Models\Job;
use Illuminate\Foundation\Bus\Dispatchable;
use Throwable;

class HandleEditedJobPoints
{
    use Dispatchable;

    private Job $job;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
        // Get the multiplier
        $multiplier = config('phoenix.job_xp_multiplier');

        // Find or create the job XP wallet
        $wallet = (new FindOrCreateWallet())->execute($this->job->user, 'Job XP');

        // Get the old distance
        $oldDistance = $this->job->getOriginal('distance');

        // Get the distance difference
        $distanceDifference = $this->job->distance - $oldDistance;

        // Deposit XP if the distance has increased
        if ($distanceDifference > 0) {
            $wallet->deposit($distanceDifference * $multiplier, ['description' => 'Edited job', 'job_id' => $this->job->id]);
        }

        // Withdraw XP if the distance has decreased
        if ($distanceDifference < 0) {
            $wallet->withdraw(abs($distanceDifference * $multiplier), ['description' => 'Edited job', 'job_id' => $this->job->id]);
        }

        event(new UserPointsChanged($this->job->user));
    }
}
