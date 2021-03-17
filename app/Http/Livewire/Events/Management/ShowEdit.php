<?php

namespace App\Http\Livewire\Events\Management;

use App\Models\Event;
use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ShowEdit extends Component
{
    public Event $event;

    public EloquentCollection $manage_event_users;

    public string $name = '';
    public string $featured_image_url = '';
    public string $map_image_url = '';
    public string $description = '';
    public string $server = '';
    public string $required_dlcs = '';
    public string $departure_location = '';
    public string $arrival_location = '';
    public string $start_date = '';
    public ?string $distance = '';
    public string $points = '';
    public string $game_id = '';
    public string $published = '1';
    public string $featured = '';
    public string $external_event = '';
    public string $public_event = '';
    public string $hosted_by = '';

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'featured_image_url' => ['required', 'url'],
            'map_image_url' => ['sometimes', 'url'],
            'description' => ['required', 'string'],
            'server' => ['sometimes', 'string'],
            'required_dlcs' => ['sometimes', 'string'],
            'departure_location' => ['sometimes', 'string'],
            'arrival_location' => ['sometimes', 'string'],
            'start_date' => ['required', 'date'],
            'distance' => ['sometimes', 'integer', 'min:1'],
            'points' => ['required', 'integer', 'min:100', 'max:500'],
            'game_id' => ['sometimes', 'integer'],
            'published' => ['required', 'boolean'],
            'featured' => ['sometimes', 'boolean'],
            'external_event' => ['sometimes', 'boolean'],
            'public_event' => ['sometimes', 'boolean'],
            'hosted_by' => ['required', 'int'],
        ];
    }

    public function render()
    {
        return view('livewire.events.management.edit')->extends('layouts.app');
    }

    public function submit()
    {
        $event = $this->event;
        $validatedData = $this->validate();

        $event->name = $validatedData['name'];
        $event->featured_image_url = $validatedData['featured_image_url'];
        $event->map_image_url = $validatedData['map_image_url'];
        $event->description = $validatedData['description'];
        $event->server = $validatedData['server'];
        $event->required_dlcs = $validatedData['required_dlcs'];
        $event->departure_location = $validatedData['departure_location'];
        $event->arrival_location = $validatedData['arrival_location'];
        $event->start_date = $validatedData['start_date'];
        $event->distance = (int)$validatedData['distance'] ?: null;
        $event->points = (int)$validatedData['points'];
        $event->game_id = (int)$validatedData['game_id'];
        $event->published = (bool)$validatedData['published'];
        $event->featured = (bool)$validatedData['featured'];
        $event->external_event = (bool)$validatedData['external_event'];
        $event->public_event = (bool)$validatedData['public_event'];
        $event->hosted_by = (int)$validatedData['hosted_by'];

        $event->save();

        session()->flash('alert', ['type' => 'success', 'message' => "Event <b>$event->name</b> successfully updated!"]);

        return redirect(route('event-management.index'));
    }

    public function mount(Event $event): void
    {
        $this->event = $event;

        $this->manage_event_users = Permission::findByName('manage events')->users;
        $this->manage_event_users = $this->manage_event_users->merge(Role::findByName('super admin')->users);

        $this->name = $this->event->name;
        $this->featured_image_url = $this->event->featured_image_url;
        $this->map_image_url = $this->event->map_image_url;
        $this->description = $this->event->description;
        $this->server = $this->event->server;
        $this->required_dlcs = $this->event->required_dlcs;
        $this->departure_location = $this->event->departure_location;
        $this->arrival_location = $this->event->arrival_location;
        $this->start_date = Carbon::parse($this->event->start_date)->format('Y-m-d\TH:i');
        $this->distance = $this->event->distance;
        $this->points = $this->event->points;
        $this->game_id = $this->event->game_id;
        $this->published = (int)$this->event->published;
        $this->featured = $this->event->featured;
        $this->external_event = $this->event->external_event;
        $this->public_event = $this->event->public_event;
        $this->hosted_by = $this->event->hosted_by;
    }

    public function getTruckersMPEventData(): Collection
    {
        return Cache::remember($this->tmp_event_id . "_tmp_event_data", 86400, function () {
            $client = new Client();

            $response = $client->get('https://api.truckersmp.com/v2/events/' . $this->tmp_event_id)->getBody();
            $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

            return collect($response);
        });
    }

    public function delete()
    {
        $this->event->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'Event deleted successfully!']);
        return redirect(route('event-management.index'));
    }
}
