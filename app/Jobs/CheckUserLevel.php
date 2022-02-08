<?php

namespace App\Jobs;

use App\Models\DriverLevel;
use App\Models\User;
use App\Notifications\DriverLevelDown;
use App\Notifications\DriverLevelUp;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use RestCord\DiscordClient;
use Throwable;

class CheckUserLevel implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected User $user;

    protected bool $notifyOnDiscord;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, bool $notifyOnDiscord = true)
    {
        $this->user = $user;
        $this->notifyOnDiscord = $notifyOnDiscord;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;

        $currentLevel = $user->driver_level;
        $calculatedLevel = $user->calculateUserLevel();

        if ($calculatedLevel < $currentLevel) {
            $this->handleLevelDown();
        }

        if ($calculatedLevel > $currentLevel) {
            $this->handleLevelUp();
        }
    }

    /**
     * @throws Throwable
     */
    public function handleLevelDown(): void
    {
        $this->user->updateOrFail(['driver_level' => $this->user->calculateUserLevel()]);

        // If the new level is a milestone level, use it for the new role
        if ($this->user->driverLevel->milestone) {
            $milestoneLevel = $this->user->driverLevel->id;
        } else {
            // Otherwise, use the user's previous milestone level
            $milestoneLevel = $this->user->previousMilestoneLevel();
        }

        // Change the user's Discord role
        $this->changeDiscordRank($milestoneLevel);

        // Send a level down notification
        $this->user->notify(new DriverLevelDown($this->user));
    }

    /**
     * Handle the user level up.
     *
     * @throws Throwable
     */
    public function handleLevelUp(): void
    {
        $this->user->updateOrFail(['driver_level' => $this->user->calculateUserLevel()]);

        // Announce the level up if the new level is a milestone
        if ($this->user->driverLevel->milestone) {
            // Change the user's Discord role
            $this->changeDiscordRank($this->user->driver_level);

            if ($this->notifyOnDiscord) {
                // Announce the level up in Discord
                Http::post(config('services.discord.webhooks.member-chat'), [
                    'embeds' => [
                        [
                            'title' => "{$this->user->username} has leveled up to **Driver Level {$this->user->driver_level}**!",
                            'description' => "Their total XP is now {$this->user->totalDriverPoints()}. Enjoy the new rank!",
                            'color' => 15228164, // #E85D04
                            'footer' => [
                                'text' => 'PhoenixBase',
                                'icon_url' => 'https://base.phoenixvtc.com/img/logo.png',
                            ],
                            'timestamp' => Carbon::now(),
                        ],
                    ],
                ]);
            }

            // Send a level up notification
            $this->user->notify(new DriverLevelUp($this->user));
        }

        // Check if the level doesn't have at least 10 levels above it
        if (DriverLevel::query()->whereKey($this->user->driver_level + 10)->doesntExist()) {
            // Post a warning in the #management channel on Discord
            Http::post(config('services.discord.webhooks.management'), [
                'embeds' => [
                    [
                        'title' => "⚠️ Heads-up! We're running out of driver levels! ⚠️",
                        'description' => "User {$this->user->username} has levelled up to **level {$this->user->driver_level}**, but they will run out of levels in 10 level-ups or less. Please consider adding more levels.",
                        'color' => 15228164, // #E85D04
                        'footer' => [
                            'text' => 'PhoenixBase',
                            'icon_url' => 'https://base.phoenixvtc.com/img/logo.png',
                        ],
                        'timestamp' => Carbon::now(),
                    ],
                ],
            ]);
        }
    }

    /**
     * Change the user's Discord role to the given (milestone) level.
     *
     * @param int $level
     * @return void
     */
    private function changeDiscordRank(int $level): void
    {
        // Return if the user doesn't have a Discord account linked
        if (! $this->user->discord) {
            return;
        }

        // Init a new Discord Client session
        $discord = new DiscordClient(['token' => config('services.discord.token')]);

        // Get and collect the guild roles
        $roles = $discord->guild->getGuildRoles(['guild.id' => (int) config('services.discord.server-id')]);
        $roles = collect($roles);

        // Find all the Driver Level roles
        $driverRoles = $roles->filter(function ($role) {
            return stripos($role->name, 'Driver Level') !== false;
        });

        // Try to find the new Driver Level role
        $driverRole = $driverRoles->where('name', 'Driver Level '.$level)->first();

        // Return if the Driver Level role couldn't be found.
        if (! $driverRole) {
            return;
        }

        // Remove all Driver Level roles from the user
        foreach ($driverRoles as $role) {
            $discord->guild->removeGuildMemberRole([
                'guild.id' => (int) config('services.discord.server-id'),
                'user.id' => (int) $this->user->discord['id'],
                'role.id' => $role->id,
            ]);
        }

        // Add the Driver Level role to the user
        $discord->guild->addGuildMemberRole([
            'guild.id' => (int) config('services.discord.server-id'),
            'user.id' => (int) $this->user->discord['id'],
            'role.id' => $driverRole->id,
        ]);
    }
}
