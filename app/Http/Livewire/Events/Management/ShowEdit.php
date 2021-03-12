<?php

namespace App\Http\Livewire\Events\Management;

use App\Models\Event;
use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ShowEdit extends Component
{
    public Event $event;
    public Collection $tmp_event_data;

    public ?string $tmp_event_url = null;
    public ?string $tmp_event_id = null;
    public ?string $tmp_event_description = '';
    public string $name = '';
    public string $featured_image_url = '';
    public string $map_image_url = '';
    public string $description = '';
    public string $server = '';
    public string $required_dlcs = '';
    public string $departure_location = '';
    public string $arrival_location = '';
    public string $start_date = '';
    public string $distance = '';
    public string $points = '';
    public string $game_id = '';
    public string $published = '1';
    public string $featured = '';
    public string $external_event = '';
    public string $public_event = '';
    public bool $form_data_changed = false;

    public function rules(): array
    {
        return [
            'tmp_event_url' => ['required_without:name'],
            'tmp_event_id' => ['required_without:name', 'integer'],
            'name' => ['required_without:tmp_event_id', 'string'],
            'featured_image_url' => ['required_without:tmp_event_id', 'url'],
            'map_image_url' => ['required_without:tmp_event_id', 'url'],
            'description' => ['required_without:tmp_event_id', 'string'],
            'server' => ['required_without:tmp_event_id', 'string'],
            'required_dlcs' => ['required_without:tmp_event_id', 'string'],
            'departure_location' => ['required_without:tmp_event_id', 'string'],
            'arrival_location' => ['required_without:tmp_event_id', 'string'],
            'start_date' => ['required_without:tmp_event_id', 'date'],
            'distance' => ['sometimes', 'integer', 'min:1'],
            'points' => ['required', 'integer', 'min:100', 'max:500'],
            'game_id' => ['required_without:tmp_event_id'],
            'published' => ['required', 'boolean'],
            'featured' => ['sometimes', 'boolean'],
            'external_event' => ['sometimes', 'boolean'],
            'public_event' => ['sometimes', 'boolean'],
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
        $event->distance = (int)$validatedData['distance'];
        $event->points = (int)$validatedData['points'];
        $event->game_id = (int)$validatedData['game_id'];
        $event->published = (bool)$validatedData['published'];
        $event->tmp_event_id = $validatedData['tmp_event_id'] ?: null;
        $event->featured = (bool)$validatedData['featured'];
        $event->external_event = (bool)$validatedData['external_event'];
        $event->public_event = (bool)$validatedData['public_event'];

        $event->save();

        session()->flash('alert', ['type' => 'success', 'message' => "Event <b>$event->name</b> successfully updated!"]);

        return redirect(route('event-management.index'));
    }

    public function mount(Event $event): void
    {
        $this->event = $event;

        $this->tmp_event_id = $this->event->tmp_event_id;
        $this->name = $this->event->name;
        $this->featured_image_url = $this->event->featured_image_url;
        $this->map_image_url = $this->event->map_image_url;
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

        if ($this->tmp_event_id) {
            $this->tmp_event_data = $this->getTruckersMPEventData();
        }
    }

    public function updated($propertyName): void
    {
        $this->tmp_event_id = $this->parseTruckersMPEventID($this->tmp_event_url, 'https://truckersmp.com/events/', '-');

        if ($this->tmp_event_id && $this->form_data_changed === false) {
            $this->setTruckersMPFormData();
        }

        $this->validateOnly($propertyName);
    }

    private function parseTruckersMPEventID($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return (int)substr($string, $ini, $len);
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

    public function setTruckersMPFormData(): void
    {
        $this->tmp_event_data = $this->getTruckersMPEventData();

        $this->name = $this->tmp_event_data['response']['name'];
        $this->featured_image_url = $this->tmp_event_data['response']['banner'];
        $this->map_image_url = $this->tmp_event_data['response']['map'];
        $this->tmp_event_description = Markdown::convertToHtml($this->tmp_event_data['response']['description']);
        $this->server = $this->tmp_event_data['response']['server']['name'];
        $this->required_dlcs = implode(',', $this->tmp_event_data['response']['dlcs']);
        $this->departure_location = $this->tmp_event_data['response']['departure']['location'] . ", " . $this->tmp_event_data['response']['departure']['city'];
        $this->arrival_location = $this->tmp_event_data['response']['arrive']['location'] . ", " . $this->tmp_event_data['response']['arrive']['city'];
        $this->start_date = Carbon::parse($this->tmp_event_data['response']['start_at'])->format('Y-m-d\TH:i');
        if ($this->tmp_event_data['response']['game'] === 'ETS2') {
            $this->game_id = 1;
        }
        if ($this->tmp_event_data['response']['game'] === 'ATS') {
            $this->game_id = 2;
        }

        $this->form_data_changed = true;
    }

    public function delete(): void
    {
        $this->event->delete();
    }
}
