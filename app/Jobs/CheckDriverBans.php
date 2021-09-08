<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CheckDriverBans implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const VTC_ID = 30294;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->sendDiscordStartedNotification();

        $response = Http::get('https://api.truckersmp.com/v2/vtc/' . self::VTC_ID . '/members/banned');

        // Return if the request failed
        if ($response->failed()) {
            return;
        }

        foreach ($response['response']['members'] as $user) {
            $userResponse = Http::get("https://api.truckersmp.com/v2/player/{$user['user_id']}");

            $userResponse = $userResponse->collect()->toArray();

            $userResponse = $userResponse['response'];

            // Request the ban information if it's public
            if ($userResponse['displayBans']) {
                $banResponse = Http::get("https://api.truckersmp.com/v2/bans/{$user['user_id']}")->collect();
                $banReason = $banResponse['response'][0]['reason'];
            }

            $this->sendDiscordNotification($user, $userResponse, $banReason ?? null);
        }

        $this->sendDiscordFinishedNotification();
    }

    private function sendDiscordNotification(array $userResponse, array $tmpData, ?string $banReason): void
    {
        try {
            $user = User::withTrashed()->where('truckersmp_id', $userResponse['user_id'])->firstOrFail();
        } catch (Exception $e) {
            return;
        }

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
