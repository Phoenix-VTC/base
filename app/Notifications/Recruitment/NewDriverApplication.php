<?php

namespace App\Notifications\Recruitment;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class NewDriverApplication extends Notification implements ShouldQueue
{
    use Queueable;

    public Application $application;

    /**
     * Create a new notification instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return [DiscordChannel::class];
    }

    /**
     * Get the Discord representation of the notification.
     *
     * @return DiscordMessage
     */
    public function toDiscord(): DiscordMessage
    {
        $body = "<@&786313989021237309>"; // @Recruitment Team

        $embed = [
            'title' => 'New Driver Application!',
            'description' => 'A new driver application has just been submitted, view the details below.',
            'url' => route('recruitment.show', $this->application->uuid),
            'color' => 14429954, // #DC2F02
            'timestamp' => $this->application->created_at,
            'author' => [
                'name' => config('app.name'),
                'url' => route('recruitment.show', $this->application->uuid),
                'icon_url' => 'https://phoenixvtc.com/assets/images/branding/logo.png'
            ],
            'fields' => [
                [
                    'name' => 'Username',
                    'value' => $this->application->username,
                ]
            ]
        ];

        return DiscordMessage::create($body, $embed);
    }
}
