<?php

namespace App\Listeners;

use App\Events\NewBlocklistEntry;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class SendNewBlocklistEntryNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param NewBlocklistEntry $event
     * @return void
     */
    public function handle(NewBlocklistEntry $event): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => 'New blocklist entry created',
                    'url' => route('user-management.blocklist.show', $event->blocklist->id),
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
