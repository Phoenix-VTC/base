<?php

namespace App\Listeners;

use App\Events\NewBlocklistEntry;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
                    'description' => "**Reason:** \n" . Str::words($event->blocklist->reason),
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
