<?php

namespace App\Http\Livewire\Events\Management;

use App\Enums\Attending;
use App\Models\Event;
use App\Notifications\Events\NewEvent;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * @property Forms\ComponentContainer $form
 */
class ShowCreate extends Component implements HasForms
{
    use WithFileUploads;
    use InteractsWithForms;

    public Collection $tmp_event_data;

    public $tmp_event_url;

    public $tmp_event_id;

    public $tmp_event_description = '';

    public $name = '';

    public $featured_image_url = '';

    public $map_image_url = '';

    public $description = '';

    public $server = '';

    public $required_dlcs = [];

    public $departure_location = '';

    public $arrival_location = '';

    public $start_date = '';

    public $distance = '';

    public $points = '';

    public $game_id = '';

    public $published = '';

    public $featured = '';

    public $external_event = '';

    public $public_event = '';

    public $hosted_by = '';

    public $announce = '';

    protected array $validationAttributes = [
        'tmp_event_url' => 'TruckersMP Event URL',
        'name' => 'Event Name',
        'description' => 'Description',
        'featured_image_url' => 'Featured Image URL',
        'start_date' => 'Departure Date and Time',
        'distance' => 'Distance',
        'points' => 'Event XP',
        'hosted_by' => 'Event Host',
        'announce' => 'Announce Event',
    ];

    protected array $messages = [
        'starts_with' => 'The URL must begin with https://',
    ];

    public function render(): View
    {
        return view('livewire.events.management.create')->extends('layouts.app');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\TextInput::make('tmp_event_url')
                                ->label('TruckersMP event URL')
                                ->url()
                                ->rule('starts_with:https://')
                                ->placeholder('https://truckersmp.com/events/123-event-name')
                                ->reactive()
                                ->afterStateUpdated(fn () => $this->setTruckersMpFormData())
                                ->helperText(function (Closure $get) {
                                    if (! $get('tmp_event_url')) {
                                        return null;
                                    }

                                    if (! $this->tmp_event_id) {
                                        return '<p class="text-red-600">Could not resolve TruckersMP Event ID.</p>';
                                    }

                                    return 'TruckersMP Event ID: '.$this->tmp_event_id;
                                }),

                            Forms\Components\TextInput::make('name')
                                ->label('Event name')
                                ->required()
                                ->placeholder("Kenji's weekly drive"),
                        ]),

                    Forms\Components\TextInput::make('featured_image_url')
                        ->label('Featured image URL')
                        ->required()
                        ->url()
                        ->rule('starts_with:https://')
                        ->rule('ends_with:.png,.jpg,.jpeg')
                        ->placeholder('https://i.imgur.com/Uv6fmAq.png')
                        ->helperText(function (Closure $get) {
                            if (! $get('featured_image_url')) {
                                return null;
                            }

                            return "<a href='{$get('featured_image_url')}' target='_blank'>View image</a>";
                        })
                        ->reactive(),

                    Forms\Components\TextInput::make('map_image_url')
                        ->label('Map image URL')
                        ->required()
                        ->url()
                        ->rule('starts_with:https://')
                        ->rule('ends_with:.png,.jpg,.jpeg')
                        ->placeholder('https://i.imgur.com/vJOyb72.png')
                        ->helperText(function (Closure $get) {
                            if (! $get('map_image_url')) {
                                return null;
                            }

                            return "<a href='{$get('map_image_url')}' target='_blank'>View image</a>";
                        })
                        ->reactive(),

                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\RichEditor::make('description')
                                ->required()
                                ->fileAttachmentsDisk('scaleway')
                                ->fileAttachmentsDirectory('event-images'),
                        ]),

                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\TextInput::make('server')
                                ->placeholder('Simulation 1'),

                            Forms\Components\TagsInput::make('required_dlcs')
                                ->label('Required DLCs')
                                ->placeholder('Enter the required DLCs here, or keep empty.')
                                ->hint('Separate each entry by a comma or enter.')
                                ->helperText('Optional, leave empty if the event is hosted in a base-game area.'),
                        ]),

                    Forms\Components\TextInput::make('departure_location')
                        ->placeholder('Kaarfor, Amsterdam'),

                    Forms\Components\TextInput::make('arrival_location')
                        ->placeholder('EuroAcres, Groningen'),

                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\DateTimePicker::make('start_date')
                                ->label('Departure date and time (UTC)')
                                ->withoutSeconds()
                                ->minDate(now())
                                ->placeholder('Please choose a date and time')
                                ->helperText(function () {
                                    return 'Current UTC date & time: **'.Carbon::now('UTC').'**';
                                })
                                ->required(),
                        ]),

                    Forms\Components\TextInput::make('distance')
                        ->hint('In kilometres')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->placeholder('1200'),

                    Forms\Components\TextInput::make('points')
                        ->label('Event XP')
                        ->required()
                        ->numeric()
                        ->minValue(100)
                        ->step(10)
                        ->hint('In steps of 10, but preferably 100')
                        ->helperText('*Event XP should be a value between 100 - 500, unless specified otherwise.*')
                        ->placeholder('100'),

                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\Radio::make('game_id')
                                ->label('Game')
                                ->required()
                                ->options([
                                    1 => 'Euro Truck Simulator 2',
                                    2 => 'American Truck Simulator',
                                ]),
                        ]),

                    Forms\Components\Select::make('hosted_by')
                        ->label('Event host')
                        ->placeholder('Choose a host/lead')
                        ->options(Event::getAvailableHosts())
                        ->required()
                        ->searchable()
                        ->hint('The user that is hosting or leading the event.'),

                    Forms\Components\Fieldset::make('Extra Options')
                        ->columns(1)
                        ->schema([
                            Forms\Components\Checkbox::make('featured')
                                ->label('Feature this event')
                                ->hint('Display the event on the top of the events page.'),

                            Forms\Components\Checkbox::make('external_event')
                                ->label('External event')
                                ->hint("If the event isn't hosted by Phoenix"),

                            Forms\Components\Checkbox::make('public_event')
                                ->label('Public event')
                                ->hint('For events that non-phoenix members can attend.'),
                        ]),

                    Forms\Components\Fieldset::make('Visibility')
                        ->columns(1)
                        ->schema([
                            Forms\Components\Toggle::make('published')
                                ->label('Publish event')
                                ->onIcon('heroicon-s-eye')
                                ->offIcon('heroicon-s-eye-off')
                                ->hint("If the event should be visible to users. Don't tick if it is a draft.")
                                ->reactive(),

                            Forms\Components\Toggle::make('announce')
                                ->label('Announce event')
                                ->onIcon('heroicon-o-bell')
                                ->offIcon('heroicon-s-x')
                                ->hint("If the event should be announced on Discord. If skipped, it can't be done afterwards.")
                                ->hidden(fn (Closure $get) => ! $get('published')),
                        ]),
                ]),
        ];
    }

    public function submit()
    {
        $validatedData = $this->form->getState();

        $event = Event::create([
            'name' => $validatedData['name'],
            'hosted_by' => $validatedData['hosted_by'],
            'featured_image_url' => $validatedData['featured_image_url'],
            'map_image_url' => $validatedData['map_image_url'],
            'description' => $validatedData['description'],
            'server' => $validatedData['server'],
            'required_dlcs' => $validatedData['required_dlcs'],
            'departure_location' => $validatedData['departure_location'],
            'arrival_location' => $validatedData['arrival_location'],
            'start_date' => $validatedData['start_date'],
            'distance' => (int) $validatedData['distance'],
            'points' => (int) $validatedData['points'],
            'game_id' => (int) $validatedData['game_id'],
            'tmp_event_id' => $this->tmp_event_id ?: null,
            'published' => (bool) $validatedData['published'],
            'featured' => (bool) $validatedData['featured'],
            'external_event' => (bool) $validatedData['external_event'],
            'public_event' => (bool) $validatedData['public_event'],
            'created_by' => Auth::id(),
        ]);

        // Add the event host to the attendance
        $event->attendees()->create([
            'user_id' => $event->hosted_by,
            'attending' => Attending::Yes,
        ]);

        if ($this->announce) {
            $event->notify(new NewEvent($event));
        }

        session()->flash('alert', ['type' => 'success', 'message' => 'Event successfully created!']);

        return redirect(route('event-management.index'));
    }

    private function parseTruckersMPEventID($string, $start, $end): int|string|null
    {
        try {
            $string = ' '.$string;
            $ini = strpos($string, $start);
            if ($ini === 0) {
                return '';
            }
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;

            return (int) substr($string, $ini, $len);
        } catch (\ValueError) {
            return null;
        }
    }

    public function getTruckersMpEventData(): Collection
    {
        return Cache::remember($this->tmp_event_id.'_tmp_event_data', 86400, function () {
            $response = Http::get("https://api.truckersmp.com/v2/events/{$this->tmp_event_id}");

            // Return an empty collection if the response failed.
            if ($response->failed()) {
                return collect();
            }

            return $response->collect();
        });
    }

    public function setTruckersMpFormData(): void
    {
        // Get the TruckersMP Event ID from the URL.
        $this->tmp_event_id = $this->parseTruckersMPEventID($this->tmp_event_url, 'https://truckersmp.com/events/', '-');

        // If the parsed ID is null (thus invalid), return.
        if ($this->tmp_event_id === null) {
            return;
        }

        // Get the event data from the API.
        $this->tmp_event_data = $this->getTruckersMpEventData();

        // If the event data is empty, return.
        if ($this->tmp_event_data->isEmpty()) {
            return;
        }

        // Set the form data from the TruckersMP API response.
        $this->form->fill([
            'tmp_event_url' => $this->tmp_event_url,
            'name' => $this->tmp_event_data['response']['name'] ?? '',
            'featured_image_url' => $this->tmp_event_data['response']['banner'] ?? '',
            'map_image_url' => $this->tmp_event_data['response']['map'] ?? '',
            'tmp_event_description' => Markdown::convertToHtml($this->tmp_event_data['response']['description'] ?? ''),
            'server' => $this->tmp_event_data['response']['server']['name'] ?? '',
            'required_dlcs' => array_values($this->tmp_event_data['response']['dlcs'] ?? []), // Only the array values, not keys
            'departure_location' => $this->tmp_event_data['response']['departure']['location'].', '.$this->tmp_event_data['response']['departure']['city'],
            'arrival_location' => $this->tmp_event_data['response']['arrive']['location'].', '.$this->tmp_event_data['response']['arrive']['city'],
            'start_date' => $this->tmp_event_data['response']['start_at'] ?? '',
            'game_id' => $this->gameNameToId($this->tmp_event_data['response']['game']),
        ]);
    }

    private function gameNameToId($game): int|null
    {
        if ($game === 'ETS2') {
            return 1;
        }

        if ($game === 'ATS') {
            return 2;
        }

        return null;
    }
}
