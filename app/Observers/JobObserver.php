<?php

namespace App\Observers;

use App\Models\Job;

class JobObserver
{
    /**
     * Handle the Job "created" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function created(Job $job): void
    {
        $user = $job->user;

        // Convert USD to EUR
        if ((int)$job->game_id === 2) {
            $income = $job->total_income * 0.83;
        } else {
            $income = $job->total_income;
        }

        $user->deposit($income, ['description' => 'Submitted job', 'job_id' => $job->id]);
    }

    /**
     * Handle the Job "updated" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function updated(Job $job): void
    {
        //
    }

    /**
     * Handle the Job "deleted" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function deleted(Job $job): void
    {
        //
    }

    /**
     * Handle the Job "restored" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function restored(Job $job): void
    {
        //
    }

    /**
     * Handle the Job "force deleted" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function forceDeleted(Job $job): void
    {
        //
    }
}
