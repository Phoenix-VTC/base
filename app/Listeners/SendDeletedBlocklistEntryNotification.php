<?php

namespace App\Listeners;

use App\Events\BlocklistEntryDeleted;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SendDeletedBlocklistEntryNotification
{
    /**
     * Handle the event.
     *
     * @param BlocklistEntryDeleted $event
     * @return void
     */
    public function handle(BlocklistEntryDeleted $event): void
    {
        Http::post(config('services.discord.webhooks.human-resources'), [
            'embeds' => [
                [
                    'title' => 'Blocklist entry deleted',
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
