<?php

namespace App\Http\Livewire\GameData\Cargos;

use App\Models\Cargo;
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

    public $name = '';
    public $dlc = '';
    public $mod = '';
    public $weight = '';
    public $game_id = 1;
    public $wot = 0;

    public function render()
    {
        return view('livewire.game-data.cargos')->extends('layouts.app');
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
                                ->required()
                        ]),

                    Forms\Components\TextInput::make('dlc')
                        ->label('DLC'),

                    Forms\Components\TextInput::make('mod'),

                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\TextInput::make('weight')
                                ->numeric()
                                ->minValue(1)
                                ->helperText('Tonnes (t) for ETS2, pounds (lb) for ATS.')
                        ]),

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

                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Radio::make('wot')
                                ->label('World of Trucks only')
                                ->boolean()
                        ]),
                ]),
        ];
    }

    public function submit(): void
    {
        $validateData = $this->form->getState();

        $cargo = Cargo::create([
            'name' => $validateData['name'],
            'dlc' => $validateData['dlc'],
            'mod' => $validateData['mod'],
            'weight' => $validateData['weight'] ?: null,
            'game_id' => $validateData['game_id'],
            'world_of_trucks' => $validateData['wot'],
        ]);

        $this->reset();

        session()->now('alert', ['type' => 'success', 'message' => "Cargo <b>$cargo->name</b> successfully added."]);
    }
}
