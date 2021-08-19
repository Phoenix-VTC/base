<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Laravel\Horizon\Events\JobFailed;

class SendFailedJobDiscordNotification
{
    /**
     * Handle the event.
     *
     * @param JobFailed $event
     * @return void
     */
    public function handle(JobFailed $event): void
    {
        Http::post(config('services.discord.webhooks.development-updates'), [
            'embeds' => [
                [
                    'url' => URL::to('horizon'),
                    'title' => "Job {$event->job->resolveName()} failed!",
                    'description' => $event->exception->getMessage(),
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
