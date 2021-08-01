<?php

namespace App\Observers;

use App\Achievements\ScreenshotChain;
use App\Models\Screenshot;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ScreenshotObserver
{
    /**
     * Handle the Screenshot "created" event.
     *
     * @param \App\Models\Screenshot $screenshot
     * @return void
     */
    public function created(Screenshot $screenshot): void
    {
        $screenshot->user->addProgress(new ScreenshotChain(), 1);

        Http::post(config('services.discord.webhooks.screenshot-hub'), [
            'embeds' => [
                [
                    'url' => route('screenshot-hub.show', $screenshot->id),
                    'title' => $screenshot->user->username . ' uploaded a new screenshot!',
                    'description' => $screenshot->description ?: null,
                    'color' => 14429954, // #DC2F02
                    'fields' => [
                        [
                            'name' => 'Title',
                            'value' => $screenshot->title,
                            'inline' => true
                        ],
                        [
                            'name' => 'Vote',
                            'value' => '[<:Upvote:841965071071707156> **Upvote**](' . route('screenshot-hub.show', $screenshot->id) . ')',
                            'inline' => true
                        ],
                    ],
                    'author' => [
                        'name' => $screenshot->user->username,
                        'url' => route('users.profile', $screenshot->user->id),
                        'icon_url' => $screenshot->user->profile_picture
                    ],
                    'footer' => [
                        'text' => 'PhoenixBase',
                        'icon_url' => 'https://base.phoenixvtc.com/img/logo.png'
                    ],
                    'timestamp' => $screenshot->created_at,
                    'image' => [
                        'url' => $screenshot->image_url
                    ],
                ]
            ],
        ]);
    }

    /**
     * Handle the Screenshot "deleted" event.
     *
     * @param \App\Models\Screenshot $screenshot
     * @return void
     */
    public function deleted(Screenshot $screenshot)
    {
        Storage::disk('scaleway')->delete($screenshot->image_path);
    }

    /**
     * Handle the Screenshot "force deleted" event.
     *
     * @param \App\Models\Screenshot $screenshot
     * @return void
     */
    public function forceDeleted(Screenshot $screenshot)
    {
        Storage::disk('scaleway')->delete($screenshot->image_path);
    }
}
