<?php

namespace App\Http\Livewire\Jobs;

use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use Closure;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

/**
 * @property Forms\ComponentContainer $form
 */
class ShowRequestGameDataPage extends Component implements HasForms
{
    use InteractsWithForms;

    public $type;
    public $game_id;
    public $name;
    public $category;
    public $specialization;
    public $country;
    public $dlc;
    public $mod;
    public $weight;
    public $wot;
    public $x;
    public $z;

    protected array $validationAttributes = [
        'wot' => 'World of Trucks'
    ];

    public function render()
    {
        return view('livewire.jobs.show-request-game-data-page')->extends('layouts.app');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Select::make('type')
                        ->required()
                        ->placeholder('Please choose a type')
                        ->options([
                            'city' => 'City',
                            'company' => 'Company',
                            'cargo' => 'Cargo',
                        ])
                        ->reactive(),

                    Forms\Components\Select::make('game_id')
                        ->required()
                        ->label('Game')
                        ->placeholder('Please choose a game')
                        ->options([
                            1 => 'Euro Truck Simulator 2',
                            2 => 'American Truck Simulator',
                        ])
                        ->hidden(fn(Closure $get) => !$get('type')),

                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->placeholder('MiniMarket')
                                ->required()
                                ->hidden(fn(Closure $get) => !$get('type')),

                            Forms\Components\TextInput::make('country')
                                ->label('Country or US state')
                                ->placeholder('Germany')
                                ->required()
                                ->hidden(fn(Closure $get) => $get('type') !== 'city'),

                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\TextInput::make('category')
                                        ->placeholder('Supermarkets and stores'),

                                    Forms\Components\TextInput::make('specialization')
                                        ->placeholder('Supermarket chain'),
                                ])
                                ->hidden(fn(Closure $get) => $get('type') !== 'company'),

                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\TextInput::make('dlc')
                                        ->label('DLC')
                                        ->placeholder('Vive la France!, Road to the Black Sea')
                                        ->helperText('If multiple, separate by comma.'),

                                    Forms\Components\TextInput::make('mod')
                                        ->placeholder('ProMods'),
                                ])
                                ->hidden(fn(Closure $get) => !$get('type')),

                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\TextInput::make('weight')
                                        ->numeric()
                                        ->minValue(1)
                                        ->placeholder('12')
                                        ->helperText('Tonnes (t) for ETS2, pounds (lb) for ATS.')
                                ])
                                ->hidden(fn(Closure $get) => $get('type') !== 'cargo'),

                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\Radio::make('wot')
                                        ->label('World of Trucks only')
                                        ->boolean()
                                ])
                                ->hidden(fn(Closure $get) => $get('type') !== 'cargo'),

                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\TextInput::make('x')
                                        ->numeric()
                                        ->label('X-coordinate')
                                        ->helperText('The **in-game** coordinates.<br>Optional, but please try to specify.')
                                        ->placeholder('-6333'),

                                    Forms\Components\TextInput::make('z')
                                        ->numeric()
                                        ->label('Z-coordinate')
                                        ->helperText('The **in-game** coordinates.<br>Optional, but please try to specify.')
                                        ->placeholder('2532'),
                                ])
                                ->hidden(fn(Closure $get) => $get('type') !== 'city'),
                        ]),
                ]),
        ];
    }

    public function submit(): void
    {
        $validatedData = $this->form->getState();

        switch ($this->type) {
            case 'city':
                City::create([
                    'real_name' => ucwords($validatedData['name']),
                    'name' => Str::snake($validatedData['name']),
                    'country' => ucwords($validatedData['country']),
                    'dlc' => ucwords($validatedData['dlc']),
                    'mod' => ucwords($validatedData['mod']),
                    'game_id' => $validatedData['game_id'],
                    'x' => $validatedData['x'] ?: null,
                    'z' => $validatedData['z'] ?: null,
                    'approved' => false,
                    'requested_by' => Auth::id(),
                ]);
                break;
            case 'company':
                Company::create([
                    'name' => Str::snake($validatedData['name']),
                    'category' => ucwords($validatedData['category']),
                    'specialization' => ucwords($validatedData['specialization']),
                    'dlc' => ucwords($validatedData['dlc']),
                    'mod' => ucwords($validatedData['mod']),
                    'game_id' => $validatedData['game_id'],
                    'approved' => false,
                    'requested_by' => Auth::id(),
                ]);
                break;
            case 'cargo':
                Cargo::create([
                    'name' => ucwords($validatedData['name']),
                    'dlc' => ucwords($validatedData['dlc']),
                    'mod' => ucwords($validatedData['mod']),
                    'weight' => $validatedData['weight'] ?: null,
                    'game_id' => $validatedData['game_id'],
                    'world_of_trucks' => (bool)$this->wot,
                    'approved' => false,
                    'requested_by' => Auth::id(),
                ]);
                break;
        }

        $name = $validatedData['name'];

        session()->now('alert', ['type' => 'success', 'message' => ucfirst($validatedData['type']) . " <b>$name</b> successfully requested.<br>You will receive a notification on the Base when your request has been approved or denied."]);

        $this->reset();
    }
}
