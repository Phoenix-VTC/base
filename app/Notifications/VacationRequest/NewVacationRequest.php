<?php

namespace App\Notifications\VacationRequest;

use App\Models\VacationRequest;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class NewVacationRequest extends Notification implements ShouldQueue
{
    use Queueable;

    public VacationRequest $vacation_request;

    /**
     * Create a new notification instance.
     *
     * @param VacationRequest $vacation_request
     */
    public function __construct(VacationRequest $vacation_request)
    {
        $this->vacation_request = $vacation_request;
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
        $body = '<@&786313992020819989>'; // @Human Resources Team

        $embed = [
            'title' => 'New Vacation Request!',
            'description' => 'A new vacation request has just been submitted, view the details below.',
            'url' => route('vacation-requests.manage.index'),
            'color' => 14429954, // #DC2F02
            'timestamp' => $this->vacation_request->created_at,
            'author' => [
                'name' => config('app.name'),
                'url' => route('vacation-requests.manage.index'),
                'icon_url' => 'https://base.phoenixvtc.com/img/logo.png',
            ],
            'fields' => [
                [
                    'name' => 'Username',
                    'value' => $this->vacation_request->user->username,
                ],
                [
                    'name' => 'Leaving Phoenix',
                    'value' => $this->vacation_request->leaving ? 'Yes' : 'No',
                ],
            ],
        ];

        if (! $this->vacation_request->leaving) {
            $embed['fields'][] = [
                'name' => 'Starts In',
                'value' => Carbon::parse($this->vacation_request->start_date)->diffForHumans(),
            ];
        }

        return DiscordMessage::create($body, $embed);
    }
}
