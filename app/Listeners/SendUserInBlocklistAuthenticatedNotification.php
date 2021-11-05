<?php

namespace App\Listeners;

use App\Events\UserInBlocklistAuthenticated;
use App\Models\Blocklist;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class SendUserInBlocklistAuthenticatedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param UserInBlocklistAuthenticated $event
     * @return void
     */
    public function handle(UserInBlocklistAuthenticated $event): void
    {
        $user = $event->user;
        $triggerValue = $event->triggerValue;

        $blocklist = Blocklist::query()
            ->exactSearch($triggerValue)
            ->first();

        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => 'A blocklisted user logged in',
                    'url' => route('user-management.blocklist.show', $blocklist->id),
                    'description' => "**Trigger value:** `{$triggerValue}`",
                    'color' => 14429954, // #DC2F02
                    'fields' => [
                        [
                            'name' => 'PhoenixBase Profile',
                            'value' => '[' . $user->username . '](' . route('users.profile', $user->id) . ')',
                            'inline' => true
                        ],
                        [
                            'name' => 'Blocklist Entry',
                            'value' => '[View blocklist entry](' . route('user-management.blocklist.show', $blocklist->id) . ')',
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
}
