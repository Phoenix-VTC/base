<?php

namespace App\Observers;

use App\Achievements\ATruckCarryingTrucks;
use App\Achievements\HouseWarming;
use App\Achievements\JobChain;
use App\Achievements\JobStonks;
use App\Achievements\LongDrive;
use App\Achievements\MoneyMan;
use App\Enums\JobStatus;
use App\Models\Job;
use Bavix\Wallet\Models\Transaction;

class JobObserver
{
    /**
     * Handle the Job "created" event.
     *
     * @param \App\Models\Job $job
     * @return void
     */
    public function created(Job $job): void
    {
        if ($job->status !== JobStatus::Complete) {
            return;
        }

        $user = $job->user;

        $user->deposit($job->total_income, ['description' => 'Submitted job', 'job_id' => $job->id]);

        // Handle achievement unlocking
        $this->handleAchievements($job);
    }

    /**
     * Handle the Job "updated" event.
     *
     * @param \App\Models\Job $job
     * @return void
     */
    public function updated(Job $job): void
    {
        if ($job->status !== JobStatus::Complete) {
            return;
        }

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
     * @param \App\Models\Job $job
     * @return void
     */
    public function deleted(Job $job): void
    {
        if ($job->status !== JobStatus::Complete) {
            return;
        }

        $job->user->withdraw($job->total_income, ['description' => 'Deleted job', 'job_id' => $job->id]);

        // Remove one progress point on the job achievement chain
        $job->user->removeProgress(new JobChain(), 1);
    }

    /**
     * Handle the Job "restored" event.
     *
     * @param \App\Models\Job $job
     * @return void
     */
    public function restored(Job $job): void
    {
        //
    }

    /**
     * Handle the Job "force deleted" event.
     *
     * @param \App\Models\Job $job
     * @return void
     */
    public function forceDeleted(Job $job): void
    {
        //
    }

    private function handleAchievements(Job $job): void
    {
        $user = $job->user;
        $user->addProgress(new JobChain(), 1);

        // Long Drive
        if ($job->distance >= 2000) {
            $user->unlock(new LongDrive());
        }

        // Money Man
        if ($job->total_income >= 100000) {
            $user->unlock(new MoneyMan());
        }

        // Stonks
        if ($job->total_income >= 200000 && $job->distance >= 2200) {
            $user->unlock(new JobStonks());
        }

        // A truck carrying trucks
        $truckCargos = [
            'kenworth trucks',
            'volvo trucks',
            'scania trucks'
        ];

        if (in_array(strtolower($job->cargo->name), $truckCargos, true)) {
            $user->unlock(new ATruckCarryingTrucks());
        }

        // House Warming
        if ($job->cargo->name === 'Turnkey House Construction') {
            $user->unlock(new HouseWarming());
        }
    }
}
