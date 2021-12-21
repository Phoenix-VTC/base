<?php

namespace App\Http\Livewire\Events\Management;

use App\Models\Event;
use App\Rules\Events\UniqueForDay;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Storage;

class ShowEdit extends Component
{
    use WithFileUploads;

    public Event $event;

    public EloquentCollection $manage_event_users;

    public ?int $tmp_event_id = null;

    public string $name = '';
    public string $featured_image_url = '';
    public string $map_image_url = '';
    public string $description = '';
    public array|string $images = [];
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
            'featured_image_url' => ['required', 'url', 'starts_with:https://', 'ends_with:.png,.jpg,.jpeg'],
            'map_image_url' => ['sometimes', 'url', 'starts_with:https://', 'ends_with:.png,.jpg,.jpeg'],
            'description' => ['required_without:tmp_event_id', 'string'],
            'server' => ['sometimes', 'string'],
            'required_dlcs' => ['sometimes', 'string'],
            'departure_location' => ['sometimes', 'string'],
            'arrival_location' => ['sometimes', 'string'],
            'start_date' => ['required', 'date', new UniqueForDay($this->event->id)],
            'distance' => ['required', 'integer', 'min:0'],
            'points' => ['required', 'integer', 'min:100', 'max:500'],
            'game_id' => ['sometimes', 'integer'],
            'published' => ['required', 'boolean'],
            'featured' => ['sometimes', 'boolean'],
            'external_event' => ['sometimes', 'boolean'],
            'public_event' => ['sometimes', 'boolean'],
            'hosted_by' => ['required', 'int'],
        ];
    }

    protected array $messages = [
        'starts_with' => 'The URL must begin with https://',
    ];

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
        $event->distance = (int)$validatedData['distance'];
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

        $this->manage_event_users = Role::findByName('event team')->users;
        $this->manage_event_users = $this->manage_event_users->merge(Role::findByName('manager')->users);

        $this->tmp_event_id = $this->event->tmp_event_id ?? null;

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

        if ($this->event->is_past) {
            session()->now('alert', ['type' => 'info', 'title' => 'Heads-up!', 'message' => "You're editing an event that is in the past."]);
        }
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
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

    public function completeImageUpload(string $uploadedUrl, string $trixUploadCompletedEvent){
        foreach($this->images as $image){
            if($image->getFilename() == $uploadedUrl) {
                $newFilename = $image->storePublicly('event-images', 'scaleway');

                $url = Storage::disk('scaleway')->url($newFilename);

                $this->dispatchBrowserEvent($trixUploadCompletedEvent, [
                    'url' => $url,
                    'href' => $url,
                ]);
            }
        }
    }
}
