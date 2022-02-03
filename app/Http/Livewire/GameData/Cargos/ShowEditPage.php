<?php

namespace App\Http\Livewire\GameData\Cargos;

use App\Enums\JobStatus;
use App\Models\Cargo;
use App\Notifications\GameDataRequestApproved;
use App\Notifications\GameDataRequestDenied;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Throwable;

/**
 * @property Forms\ComponentContainer $form
 */
class ShowEditPage extends Component implements HasForms
{
    use InteractsWithForms;

    public Cargo $cargo;

    public $name;
    public $dlc;
    public $mod;
    public $weight;
    public $game_id;
    public $wot;

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->cargo->name,
            'dlc' => $this->cargo->dlc,
            'mod' => $this->cargo->mod,
            'weight' => $this->cargo->weight,
            'game_id' => $this->cargo->game_id,
            'wot' => $this->cargo->world_of_trucks,
        ]);
    }

    public function render()
    {
        return view('livewire.game-data.cargos-edit')->extends('layouts.app');
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

    public function submit()
    {
        $validatedData = $this->form->getState();

        if (!$this->cargo->approved) {
            $this->forgetUnapprovedGameDataCount();

            session()->flash('alert', ['type' => 'success', 'message' => 'Cargo request <b>' . $this->cargo->name . '</b> successfully approved.']);

            // Only notify the user if the user still exists
            if ($this->cargo->requester()->exists()) {
                $this->cargo->requester->notify(new GameDataRequestApproved($this->cargo));
            }

            $approved = true;
        } else {
            session()->flash('alert', ['type' => 'success', 'message' => 'Cargo <b>' . $this->cargo->name . '</b> successfully updated.']);
        }

        $this->cargo->update([
            'name' => $validatedData['name'],
            'dlc' => $validatedData['dlc'],
            'mod' => $validatedData['mod'],
            'weight' => $validatedData['weight'] ?: null,
            'game_id' => $validatedData['game_id'],
            'world_of_trucks' => $validatedData['wot'],
            'approved' => true,
        ]);

        if (($approved ?? false)) {
            // If the pending city has jobs attached, loop through those jobs
            // and change the status to incomplete if those jobs don't have any pending game data
            if ($this->cargo->jobs->count()) {
                foreach ($this->cargo->jobs as $job) {
                    if (!$job->hasPendingGameData()) {
                        $job->update(['status' => JobStatus::Incomplete]);
                    }
                }
            }
        }

        return redirect()->route('game-data.cargos');
    }

    public function delete()
    {
        if (!$this->cargo->approved) {
            $this->forgetUnapprovedGameDataCount();

            // Only notify the user if the user still exists
            if ($this->cargo->requester()->exists()) {
                $this->cargo->requester->notify(new GameDataRequestDenied($this->cargo));
            }

            session()->flash('alert', ['type' => 'success', 'message' => 'Cargo request <b>' . $this->cargo->name . '</b> successfully denied.']);
        } else {
            session()->flash('alert', ['type' => 'success', 'message' => 'Cargo successfully deleted!']);
        }

        try {
            $this->cargo->deleteOrFail();
        } catch (Throwable) {
            session()->now('alert', ['type' => 'danger', 'message' => 'You can\'t delete this cargo, it\'s used in a job somewhere!']);

            return;
        }

        return redirect()->route('game-data.cargos');
    }

    private function forgetUnapprovedGameDataCount(): void
    {
        Cache::forget('unapproved_game_data_count');
    }
}
