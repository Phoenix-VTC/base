<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CheckDriverBans implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->onQueue('redis-long-running');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendDiscordStartedNotification();

        User::chunk(60, function ($users) {
            foreach ($users as $user) {
                $response = Http::get("https://api.truckersmp.com/v2/player/$user->truckersmp_id");

                // Continue if the request failed
                if ($response->failed()) {
                    continue;
                }

                $response = $response->collect()->toArray();

                // Notify & continue if there are any errors in the response
                if ($response['error']) {
                    $this->sendDiscordErrorNotification($user, $response);

                    sleep(1);
                    continue;
                }

                $response = $response['response'];

                // Continue if the user isn't currently banned
                if ($response['banned'] === false) {
                    sleep(1);
                    continue;
                }

                // Request the ban information if it's public
                if ($response['displayBans']) {
                    $banResponse = Http::get("https://api.truckersmp.com/v2/bans/$user->truckersmp_id")->collect();
                    $banReason = $banResponse['response'][0]['reason'];
                }

                $this->sendDiscordNotification($user, $response, $banReason ?? null);

                sleep(1);
            }

            // Wait for 60 seconds after each chunk, otherwise we make the TMP API sad
            sleep(60);
        });

        $this->sendDiscordFinishedNotification();
    }

    private function sendDiscordNotification(User $user, array $tmpData, ?string $banReason): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => $user->username . ' is currently banned on TruckersMP',
                    'description' => $banReason ?? 'Can\'t find the reason, ban history is private.',
                    'color' => 14429954, // #DC2F02
                    'fields' => [
                        [
                            'name' => 'PhoenixBase Profile',
                            'value' => '[' . $user->username . '](' . route('users.profile', $user->id) . ')',
                            'inline' => true
                        ],
                        [
                            'name' => 'TruckersMP Profile',
                            'value' => '[' . $tmpData['name'] . '](https://truckersmp.com/user/' . $tmpData['id'] . ')',
                            'inline' => true
                        ],
                        [
                            'name' => 'Banned Until',
                            'value' => $tmpData['bannedUntil'] ?: 'Permanent',
                            'inline' => false
                        ],
                        [
                            'name' => 'Active Bans',
                            'value' => $tmpData['bansCount'],
                            'inline' => true
                        ],
                    ],
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png'
                    ],
                    'timestamp' => Carbon::now(),
                ]
            ],
        ]);
    }

    private function sendDiscordErrorNotification(User $user, array $tmpData): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => 'Failed to resolve TruckersMP data for ' . $user->username,
                    'description' => 'Error message: `' . $tmpData['response'] . '`',
                    'color' => 14429954, // #DC2F02
                    'fields' => [
                        [
                            'name' => 'PhoenixBase Profile',
                            'value' => '[' . $user->username . '](' . route('users.profile', $user->id) . ')',
                            'inline' => true
                        ],
                        [
                            'name' => 'TruckersMP Profile',
                            'value' => '[' . $user->truckersmp_id . '](https://truckersmp.com/user/' . $user->truckersmp_id . ')',
                            'inline' => true
                        ]
                    ],
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png'
                    ],
                    'timestamp' => Carbon::now(),
                ]
            ],
        ]);
    }

    private function sendDiscordStartedNotification(): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => 'Daily ban check started',
                    'color' => 5793266, // #5865F2
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png'
                    ],
                    'timestamp' => Carbon::now(),
                ]
            ],
        ]);
    }

    private function sendDiscordFinishedNotification(): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => 'Daily ban check finished',
                    'description' => 'Checked ' . User::count() . ' users.',
                    'color' => 5763719, // #57F287
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png'
                    ],
                    'timestamp' => Carbon::now(),
                ]
            ],
        ]);
    }
}
