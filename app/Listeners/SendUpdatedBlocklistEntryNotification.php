<?php

namespace App\Listeners;

use App\Events\BlocklistEntryUpdated;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class SendUpdatedBlocklistEntryNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param BlocklistEntryUpdated $event
     * @return void
     */
    public function handle(BlocklistEntryUpdated $event): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => 'Blocklist entry edited',
                    'url' => route('user-management.blocklist.show', $event->blocklist->id),
                    'color' => 14429954, // #DC2F02
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
