<?php

namespace App\Http\Livewire\GameData\Cities;

use App\Models\City;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

/**
 * @property Forms\ComponentContainer $form
 */
class ShowIndexPage extends Component implements HasForms
{
    use InteractsWithForms;

    public $real_name;
    public $name;
    public $country;
    public $dlc;
    public $mod;
    public $game_id = 1;
    public $x;
    public $z;

    public function render()
    {
        return view('livewire.game-data.cities')->extends('layouts.app');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('real_name')
                        ->helperText('Example: Frankfurt am Main')
                        ->required(),

                    Forms\Components\TextInput::make('name')
                        ->helperText('Example: frankfurt_am_main')
                        ->required(),

                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\TextInput::make('country')
                                ->label('Country or US state')
                                ->required(),
                        ]),

                    Forms\Components\TextInput::make('dlc')
                        ->label('DLC'),

                    Forms\Components\TextInput::make('mod'),

                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Select::make('game_id')
                                ->label('Game')
                                ->options([
                                    1 => 'Euro Truck Simulator 2',
                                    2 => 'American Truck Simulator',
                                ])
                                ->required()
                        ]),

                    Forms\Components\TextInput::make('x')
                        ->numeric()
                        ->label('X-coordinate')
                        ->helperText('Optional, but please try to specify.'),

                    Forms\Components\TextInput::make('z')
                        ->numeric()
                        ->label('Z-coordinate')
                        ->helperText('Optional, but please try to specify.'),
                ]),
        ];
    }

    public function submit(): void
    {
        $validatedData = $this->form->getState();

        $city = City::create([
            'real_name' => $validatedData['real_name'],
            'name' => $validatedData['name'],
            'country' => $validatedData['country'],
            'dlc' => $validatedData['dlc'],
            'mod' => $validatedData['mod'],
            'game_id' => $validatedData['game_id'],
            'x' => $validatedData['x'] ?: null,
            'z' => $validatedData['z'] ?: null,
        ]);

        $this->reset();

        session()->now('alert', ['type' => 'success', 'message' => "City <b>$city->real_name</b> successfully added."]);
    }
}
