<?php

namespace App\Notifications\Events;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class NewEvent extends Notification implements ShouldQueue
{
    use Queueable;

    public Event $event;

    public array $embed;

    /**
     * Create a new notification instance.
     *
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
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
        $route = route('events.show', ['id' => $this->event->id, 'slug' => $this->event->slug]);

        $this->embed = [
            'title' => 'New Event: ' . $this->event->name,
            'description' => Str::words(strip_tags($this->event->description), 40),
            'url' => $route,
            'color' => 14429954, // #DC2F02
            'timestamp' => $this->event->created_at,
            'author' => [
                'name' => $this->event->host->username,
                'url' => $route,
                'icon_url' => $this->event->host->profile_picture
            ],
            'fields' => [],
            'footer' => [
                'text' => 'PhoenixEvents',
                'icon_url' => 'https://phoenixvtc.com/assets/images/branding/logo.png',
            ]
        ];

        $this->addEmbedFields();

        return DiscordMessage::create('', $this->embed);
    }

    private function addEmbedFields(): void
    {
        $this->embed['fields'][] = [
            'name' => 'Start Date and Time',
            'value' => $this->event->start_date->format('d M H:i'),
            'inline' => true,
        ];

        if ($this->event->departure_location) {
            $this->embed['fields'][] = [
                'name' => 'Meetup Location',
                'value' => $this->event->departure_location,
                'inline' => true,
            ];
        }

        if ($this->event->server) {
            $this->embed['fields'][] = [
                'name' => 'Server',
                'value' => $this->event->server,
                'inline' => true,
            ];
        }

        if ($this->event->required_dlcs) {
            $this->embed['fields'][] = [
                'name' => 'Required DLCs',
                'value' => $this->event->required_dlcs,
                'inline' => true,
            ];
        }

        if ($this->event->distance) {
            $this->embed['fields'][] = [
                'name' => 'Distance',
                'value' => $this->event->distance . ' ' . $this->event->distance_metric ?? 'None',
                'inline' => true,
            ];
        }

        if ($this->event->is_high_rewarding) {
            $this->embed['fields'][] = [
                'name' => 'Event XP',
                'value' => $this->event->points . ' 🔥',
                'inline' => true,
            ];
        }

        if (!$this->event->is_high_rewarding) {
            $this->embed['fields'][] = [
                'name' => 'Event XP',
                'value' => $this->event->points,
                'inline' => true,
            ];
        }
    }
}
