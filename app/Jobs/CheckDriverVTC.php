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

class CheckDriverVTC implements ShouldQueue
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

        User::chunk(60, function ($users) {
            foreach ($users as $user) {
                $response = Http::get("https://api.truckersmp.com/v2/player/{$user->truckersmp_id}");

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

                // Continue if the user's VTC equals VTC_ID
                if ($response['vtc']['id'] === self::VTC_ID) {
                    sleep(1);
                    continue;
                }

                // From here on, the user isn't in Phoenix

                // Check if the user is in another VTC
                if ($response['vtc']['id'] !== 0) {
                    $this->sendInAnotherVTCNotification($user, $response);
                } else {
                    // The user is not in a VTC
                    $this->sendNotInVTCNotification($user, $response);
                }

                sleep(1);
            }

            // Wait for 60 seconds after each chunk, otherwise we make the TMP API sad
            sleep(60);
        });

        $this->sendDiscordFinishedNotification();
    }

    private function sendDiscordErrorNotification(User $user, array $tmpData): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => 'Failed to resolve TruckersMP data for '.$user->username,
                    'description' => 'Error message: `'.$tmpData['response'].'`',
                    'color' => 14429954, // #DC2F02
                    'fields' => [
                        [
                            'name' => 'PhoenixBase Profile',
                            'value' => '['.$user->username.']('.route('users.profile', $user).')',
                            'inline' => true,
                        ],
                        [
                            'name' => 'TruckersMP Profile',
                            'value' => '['.$user->truckersmp_id.'](https://truckersmp.com/user/'.$user->truckersmp_id.')',
                            'inline' => true,
                        ],
                    ],
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png',
                    ],
                    'timestamp' => Carbon::now(),
                ],
            ],
        ]);
    }

    private function sendDiscordStartedNotification(): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => 'Daily VTC check started',
                    'color' => 5793266, // #5865F2
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png',
                    ],
                    'timestamp' => Carbon::now(),
                ],
            ],
        ]);
    }

    private function sendDiscordFinishedNotification(): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => 'Daily VTC check finished',
                    'description' => 'Checked '.User::count().' users.',
                    'color' => 5763719, // #57F287
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png',
                    ],
                    'timestamp' => Carbon::now(),
                ],
            ],
        ]);
    }

    private function sendNotInVTCNotification(User $user, $response): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => $user->username.' is currently not in a VTC',
                    'color' => 14429954, // #DC2F02
                    'fields' => [
                        [
                            'name' => 'PhoenixBase Profile',
                            'value' => '['.$user->username.']('.route('users.profile', $user).')',
                            'inline' => true,
                        ],
                        [
                            'name' => 'TruckersMP Profile',
                            'value' => '['.$user->truckersmp_id.'](https://truckersmp.com/user/'.$user->truckersmp_id.')',
                            'inline' => true,
                        ],
                    ],
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png',
                    ],
                    'timestamp' => Carbon::now(),
                ],
            ],
        ]);
    }

    private function sendInAnotherVTCNotification(User $user, $response): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => "{$user->username} is currently in **{$response['vtc']['name']}**",
                    'color' => 14429954, // #DC2F02
                    'fields' => [
                        [
                            'name' => 'PhoenixBase Profile',
                            'value' => '['.$user->username.']('.route('users.profile', $user).')',
                            'inline' => true,
                        ],
                        [
                            'name' => 'TruckersMP Profile',
                            'value' => "[{$user->truckersmp_id}](https://truckersmp.com/user/{$user->truckersmp_id})",
                            'inline' => true,
                        ],
                        [
                            'name' => 'VTC',
                            'value' => "[{$response['vtc']['name']}](https://truckersmp.com/vtc/{$response['vtc']['id']})",
                            'inline' => false,
                        ],
                    ],
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
