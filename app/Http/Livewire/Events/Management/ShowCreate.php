<?php

namespace App\Http\Livewire\Events\Management;

use App\Models\Event;
use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ShowCreate extends Component
{
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
            'tmp_event_url' => ['required_without:name', 'url'],
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

    public function render(): View
    {
        return view('livewire.events.management.create')->extends('layouts.app');
    }

    public function submit()
    {
        $validatedData = $this->validate();

        Event::create([
            'name' => $validatedData['name'],
            'hosted_by' => Auth::id(),
            'featured_image_url' => $validatedData['featured_image_url'],
            'map_image_url' => $validatedData['map_image_url'],
            'description' => $validatedData['description'],
            'server' => $validatedData['server'],
            'required_dlcs' => $validatedData['required_dlcs'],
            'departure_location' => $validatedData['departure_location'],
            'arrival_location' => $validatedData['arrival_location'],
            'start_date' => $validatedData['start_date'],
            'distance' => (int)$validatedData['distance'],
            'points' => (int)$validatedData['points'],
            'game_id' => (int)$validatedData['game_id'],
            'tmp_event_id' => $this->tmp_event_id ?? null,
            'published' => (bool)$validatedData['published'],
            'featured' => (bool)$validatedData['featured'],
            'external_event' => (bool)$validatedData['external_event'],
            'public_event' => (bool)$validatedData['public_event'],
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Event successfully created!']);

        return redirect(route('event-management.index'));
    }

    public function mount(): void
    {
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
}
