<?php

namespace App\Observers;

use App\Models\Job;
use Bavix\Wallet\Models\Transaction;

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

        $user->deposit($job->total_income, ['description' => 'Submitted job', 'job_id' => $job->id]);
    }

    /**
     * Handle the Job "updated" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function updated(Job $job): void
    {
        $user = $job->user;

        // Try to find the previous job transaction(s) and sum them
        $old_income = Transaction::whereJsonContains('meta->job_id', $job->id)->sum('amount');

        $income_diff = $job->total_income - $old_income;

        // Deposit the income difference if the difference is above 1
        if ($income_diff >= 1) {
            $user->deposit($income_diff, ['description' => 'Edited job', 'job_id' => $job->id]);
        }

        // Withdraw the income difference if the difference is below 0
        if ($income_diff < 0) {
            $user->withdraw(abs($income_diff), ['description' => 'Edited job', 'job_id' => $job->id]);
        }
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
