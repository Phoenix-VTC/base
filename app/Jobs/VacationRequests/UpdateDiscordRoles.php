<?php

namespace App\Jobs\VacationRequests;

use App\Models\User;
use App\Models\VacationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use RestCord\DiscordClient;

class UpdateDiscordRoles implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        // Get all vacations request that start today
        $upcoming = VacationRequest::notLeaving()
            ->whereDate('start_date', today())
            ->get();

        // Get all vacations request that end today
        $past = VacationRequest::notLeaving()
            ->whereDate('end_date', today())
            ->get();

        // Handle the upcoming vacation requests
        $this->handleUpcomingVacationRequests($upcoming);

        // Handle the past vacation requests
        $this->handlePastVacationRequests($past);
    }

    /**
     * Handle the upcoming vacation requests
     *
     * @param Collection $vacationRequests
     * @return void
     */
    private function handleUpcomingVacationRequests(Collection $vacationRequests): void
    {
        $vacationRequests->each(function (VacationRequest $vacationRequest) {
            $user = $vacationRequest->user;

            // Update the user's role
            $this->modifyUserDiscordRole($user);
        });
    }

    /**
     * Handle the past vacation requests
     *
     * @param Collection $vacationRequests
     * @return void
     */
    private function handlePastVacationRequests(Collection $vacationRequests): void
    {
        $vacationRequests->each(function (VacationRequest $vacationRequest) {
            $user = $vacationRequest->user;

            // Update the user's role
            $this->modifyUserDiscordRole($user, true);
        });
    }

    /**
     * Modify the user's Discord role
     *
     * @param User $user
     * @param bool $remove
     * @return void
     */
    private function modifyUserDiscordRole(User $user, bool $remove = false): void
    {
        // Return if the user doesn't have a Discord account linked
        if (!$user->discord) {
            return;
        }

        // Init a new Discord Client session
        $discord = new DiscordClient(['token' => config('services.discord.token')]);

        // Get and collect the guild roles
        $guildRoles = $discord->guild->getGuildRoles(['guild.id' => (int)config('services.discord.server-id')]);
        $guildRoles = collect($guildRoles);

        // Get the correct LOA role name
        $discordRoleName = $this->getDiscordRoleName($user);

        // Find the LOA role in the guild roles
        $role = $guildRoles->where('name', $discordRoleName)->first();

        // Return if the role doesn't exist
        if (!$role) {
            return;
        }

        // Remove or add the role to the user
        if ($remove) {
            // Remove the LOA role from the user
            $discord->guild->removeGuildMemberRole([
                'guild.id' => (int)config('services.discord.server-id'),
                'user.id' => (int)$user->discord['id'],
                'role.id' => $role->id
            ]);
        } else {
            // Add the LOA role to the user
            $discord->guild->addGuildMemberRole([
                'guild.id' => (int)config('services.discord.server-id'),
                'user.id' => (int)$user->discord['id'],
                'role.id' => $role->id
            ]);
        }

        // Log the action to the HR channel
        $this->sendDiscordNotification($user, $role->id, $remove);
    }

    /**
     * Get the correct LOA Discord role name
     *
     * @param User $user
     * @return string
     */
    private function getDiscordRoleName(User $user): string
    {
        if ($user->isUpperStaff()) {
            return 'Leave of Absence | Upper Staff';
        }

        if ($user->isStaff()) {
            return 'Leave of Absence | Staff';
        }

        return 'Leave of Absence | Driver';
    }

    /**
     * Send a Discord notification in the HR channel about the LOA starting/ending
     *
     * @param User $user
     * @param int $roleId
     * @param bool $roleRemoved
     * @return void
     */
    private function sendDiscordNotification(User $user, int $roleId, bool $roleRemoved): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => "{$user->username}'s vacation request has " . ($roleRemoved ? 'ended' : 'started'),
                    'url' => route('users.profile', $user->slug),
                    'description' => $roleRemoved ? "Their <@&{$roleId}> role has been removed." : "They have been given the <@&{$roleId}> role.",
                    'color' => $roleRemoved ? 15548997 : 5763719,
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png'
                    ],
                    'timestamp' => now(),
                ]
            ],
        ]);
    }
}
