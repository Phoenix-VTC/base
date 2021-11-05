<?php

namespace App\Listeners;

use App\Events\UserInBlocklistTriedToApply;
use App\Models\Blocklist;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SendUserInBlocklistTriedToApplyNotification
{
    /**
     * Handle the event.
     *
     * @param UserInBlocklistTriedToApply $event
     * @return void
     */
    public function handle(UserInBlocklistTriedToApply $event): void
    {
        $triggerValue = $event->triggerValue;

        $blocklist = Blocklist::query()
            ->exactSearch($triggerValue)
            ->first();

        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => 'A blocklisted user tried to apply',
                    'url' => route('user-management.blocklist.show', $blocklist->id),
                    'description' => "**Trigger value:** `{$triggerValue}`",
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
}
