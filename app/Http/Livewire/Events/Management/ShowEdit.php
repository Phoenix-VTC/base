<?php

namespace App\Http\Livewire\Events\Management;

use App\Models\Event;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Livewire\Component;

/**
 * @property Forms\ComponentContainer $form
 */
class ShowEdit extends Component implements HasForms
{
    use InteractsWithForms;

    public Event $event;

    public EloquentCollection $manage_event_users;

    public $tmp_event_id = '';

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

    public $published = '1';

    public $featured = '';

    public $external_event = '';

    public $public_event = '';

    public $hosted_by = '';

    public function mount(Event $event): void
    {
        $this->event = $event;

        // Fill the form with the event data
        $this->form->fill([
            'tmp_event_id' => $this->event->tmp_event_id,
            'name' => $this->event->name,
            'featured_image_url' => $this->event->featured_image_url,
            'map_image_url' => $this->event->map_image_url,
            'description' => $this->event->description,
            'server' => $this->event->server,
            'required_dlcs' => $this->event->required_dlcs,
            'departure_location' => $this->event->departure_location,
            'arrival_location' => $this->event->arrival_location,
            'start_date' => $this->event->start_date,
            'distance' => $this->event->distance,
            'points' => $this->event->points,
            'game_id' => $this->event->game_id,
            'published' => $this->event->published,
            'featured' => $this->event->featured,
            'external_event' => $this->event->external_event,
            'public_event' => $this->event->public_event,
            'hosted_by' => $this->event->hosted_by,
        ]);

        if ($this->event->is_past) {
            session()->flash('alert', ['type' => 'info', 'title' => 'Heads-up!', 'message' => "You're editing an event that is in the past."]);
        }
    }

    protected array $messages = [
        'starts_with' => 'The URL must begin with https://',
    ];

    public function render()
    {
        return view('livewire.events.management.edit')->extends('layouts.app');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
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
                                ->minDate(Carbon::parse($this->start_date))
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
                                ->hint("If the event should be visible to users. Don't tick if it is a draft."),
                        ]),

                    Forms\Components\Fieldset::make('Advanced Options')
                        ->schema([
                            Forms\Components\Toggle::make('change_tmp_event_id')
                                ->label('Change the TruckersMP event ID')
                                ->inline(false)
                                ->helperText('If the linked TruckersMP event post got deleted, you can modify or delete the TruckersMP event ID here.')
                                ->reactive(),

                            Forms\Components\TextInput::make('tmp_event_id')
                                ->label('TruckersMP event ID')
                                ->helperText(function (Closure $get) {
                                    if (! $get('tmp_event_id')) {
                                        return null;
                                    }

                                    return "<a href='https://truckersmp.com/events/{$get('tmp_event_id')}' target='_blank'>View event post</a>";
                                })
                                ->hidden(fn (Closure $get) => ! $get('change_tmp_event_id'))
                                ->reactive(),
                        ]),
                ]),
        ];
    }

    public function submit()
    {
        $event = $this->event;
        $validatedData = $this->form->getState();

        $event->tmp_event_id = $validatedData['tmp_event_id'] ?? null;
        $event->name = $validatedData['name'];
        $event->featured_image_url = $validatedData['featured_image_url'];
        $event->map_image_url = $validatedData['map_image_url'];
        $event->description = $validatedData['description'];
        $event->server = $validatedData['server'];
        $event->required_dlcs = $validatedData['required_dlcs'];
        $event->departure_location = $validatedData['departure_location'];
        $event->arrival_location = $validatedData['arrival_location'];
        $event->start_date = $validatedData['start_date'];
        $event->distance = (int) $validatedData['distance'];
        $event->points = (int) $validatedData['points'];
        $event->game_id = (int) $validatedData['game_id'];
        $event->published = (bool) $validatedData['published'];
        $event->featured = (bool) $validatedData['featured'];
        $event->external_event = (bool) $validatedData['external_event'];
        $event->public_event = (bool) $validatedData['public_event'];
        $event->hosted_by = (int) $validatedData['hosted_by'];

        $event->save();

        session()->flash('alert', ['type' => 'success', 'message' => "Event <b>$event->name</b> successfully updated!"]);

        return redirect(route('event-management.index'));
    }
}
