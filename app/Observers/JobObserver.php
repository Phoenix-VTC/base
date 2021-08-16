<?php

namespace App\Observers;

use App\Achievements\ATruckCarryingTrucks;
use App\Achievements\HouseWarming;
use App\Achievements\JobChain;
use App\Achievements\JobStonks;
use App\Achievements\LongDrive;
use App\Achievements\MoneyMan;
use App\Models\Job;
use App\Models\User;
use Bavix\Wallet\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use RestCord\DiscordClient;

class JobObserver
{
    /**
     * Handle the Job "creating" event.
     *
     * @param \App\Models\Job $job
     * @return void
     */
    public function creating(Job $job): void
    {
        // Handle the driver ranking
        $this->handleDriverRank($job);
    }

    /**
     * Handle the Job "created" event.
     *
     * @param \App\Models\Job $job
     * @return void
     */
    public function created(Job $job): void
    {
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

    private function handleDriverRank(Job $job)
    {
        $user = $job->user;

        // If the job distance is equal to or higher than the required distance until the next driver level
        // AND if the next driver level is divisible by 10.
        if ($job->distance >= $user->requiredDistanceUntilNextLevel && ($user->driverLevel + 1) % 10 === 0) {
            // Handle Discord rank updating
            $this->handleDiscordDriverRankChange($user);

            // Handle Discord webhook notification
            $this->sendDriverLevelUpDiscordMessage($user, $job);
        }
    }

    private function handleDiscordDriverRankChange(User $user): void
    {
        // Return if the user doesn't have a Discord account linked
        if (!$user->discord) {
            return;
        }

        // Init a new Discord Client session
        $discord = new DiscordClient(['token' => config('app.discord-bot-api-token')]);

        // Get and collect the guild roles
        $roles = $discord->guild->getGuildRoles(['guild.id' => (int)config('services.discord.server-id')]);
        $roles = collect($roles);

        // Find all the Driver Level roles
        $driverRoles = $roles->filter(function ($role) {
            return false !== stristr($role->name, 'Driver Level');
        });

        // Try to find the new Driver Level role
        $driverRole = $driverRoles->where('name', 'Driver Level ' . ($user->driverLevel + 1))->first();

        // Return if the Driver Level role couldn't be found.
        if (!$driverRole) {
            return;
        }

        // Remove all Driver Level roles from the user
        foreach ($driverRoles as $role) {
            $discord->guild->removeGuildMemberRole([
                'guild.id' => (int)config('services.discord.server-id'),
                'user.id' => (int)$user->discord['id'],
                'role.id' => $role->id
            ]);
        }

        // Add the Driver Level role to the user
        $discord->guild->addGuildMemberRole([
            'guild.id' => (int)config('services.discord.server-id'),
            'user.id' => (int)$user->discord['id'],
            'role.id' => $driverRole->id
        ]);
    }

    private function sendDriverLevelUpDiscordMessage(User $user, Job $job): void
    {
        Http::post(config('services.discord.webhooks.member-chat'), [
            'embeds' => [
                [
                    'title' => "{$user->username} leveled up to **Driver Level " . ($user->driverLevel + 1) . '**!',
                    'url' => route('users.profile', $user->id),
                    'description' => 'Their total driven distance is now ' . number_format($user->jobs()->sum('distance') + $job->distance) . ' kilometres. Enjoy the new rank!',
                    'color' => 14429954, // #DC2F02
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png'
                    ],
                    'timestamp' => Carbon::now(),
                ]
            ],
        ]);
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
