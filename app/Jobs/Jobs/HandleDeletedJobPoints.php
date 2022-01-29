<?php

namespace App\Jobs\Jobs;

use App\Actions\Wallet\FindOrCreateWallet;
use App\Events\UserPointsChanged;
use App\Models\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class HandleDeletedJobPoints implements ShouldQueue
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
     * @throws \Throwable
     */
    public function handle(): void
    {
        // Get the multiplier
        $multiplier = config('phoenix.job_xp_multiplier');

        // Find or create the job XP wallet
        $wallet = (new FindOrCreateWallet())->execute($this->job->user, 'Job XP');

        $points = $this->job->distance * $multiplier;

        $wallet->withdraw($points, ['description' => 'Deleted job', 'job_id' => $this->job->id]);

        event(new UserPointsChanged($this->job->user));
    }
}
