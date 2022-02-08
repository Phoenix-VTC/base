<?php

namespace App\Http\Livewire\GameData\Companies;

use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

/**
 * @property Forms\ComponentContainer $form
 */
class ShowIndexPage extends Component implements HasForms
{
    use InteractsWithForms;

    public $name;

    public $category;

    public $specialization;

    public $dlc;

    public $mod;

    public $game_id = 1;

    public function render()
    {
        return view('livewire.game-data.companies')->extends('layouts.app');
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
                                ->required(),
                        ]),

                    Forms\Components\TextInput::make('category'),

                    Forms\Components\TextInput::make('specialization'),

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
                                ->required(),
                        ]),
                ]),
        ];
    }

    public function submit(): void
    {
        $validatedData = $this->form->getState();

        $company = Company::create([
            'name' => $validatedData['name'],
            'category' => $validatedData['category'],
            'specialization' => $validatedData['specialization'],
            'dlc' => $validatedData['dlc'],
            'mod' => $validatedData['mod'],
            'game_id' => $validatedData['game_id'],
        ]);

        $this->reset();

        session()->now('alert', ['type' => 'success', 'message' => "Company <b>$company->name</b> successfully added."]);
    }
}
