<?php

namespace App\Http\Livewire\GameData\Cities;

use App\Enums\JobStatus;
use App\Models\City;
use App\Notifications\GameDataRequestApproved;
use App\Notifications\GameDataRequestDenied;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ShowEditPage extends Component implements HasForms
{
    use InteractsWithForms;

    public City $city;

    public $real_name;
    public $name;
    public $country;
    public $dlc;
    public $mod;
    public $game_id;
    public $x;
    public $z;

    public function mount(): void
    {
        $this->form->fill([
            'real_name' => $this->city->real_name,
            'name' => $this->city->name,
            'country' => $this->city->country,
            'dlc' => $this->city->dlc,
            'mod' => $this->city->mod,
            'game_id' => $this->city->game_id,
            'x' => $this->city->x,
            'z' => $this->city->z,
        ]);
    }

    public function render()
    {
        return view('livewire.game-data.cities-edit')->extends('layouts.app');
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

    public function submit()
    {
        $validatedData = $this->form->getState();

        if (!$this->city->approved) {
            $this->forgetUnapprovedGameDataCount();

            session()->flash('alert', ['type' => 'success', 'message' => 'City request <b>' . $this->city->real_name . '</b> successfully approved.']);

            // Only notify the user if the user still exists
            if ($this->city->requester()->exists()) {
                $this->city->requester->notify(new GameDataRequestApproved($this->city));
            }

            $approved = true;
        } else {
            session()->flash('alert', ['type' => 'success', 'message' => 'City <b>' . $this->city->name . '</b> successfully updated.']);
        }

        $this->city->update([
            'real_name' => $validatedData['real_name'],
            'name' => $validatedData['name'],
            'country' => $validatedData['country'],
            'dlc' => $validatedData['dlc'],
            'mod' => $validatedData['mod'],
            'game_id' => $validatedData['game_id'],
            'x' => $validatedData['x'] ?: null,
            'z' => $validatedData['z'] ?: null,
            'approved' => true,
        ]);

        if (($approved ?? false)) {
            // If the pending city has jobs attached, loop through those jobs
            // and change the status to incomplete if those jobs don't have any pending game data
            if ($this->city->pickupJobs->count() || $this->city->destinationJobs->count()) {
                foreach ($this->city->pickupJobs as $job) {
                    if (!$job->hasPendingGameData) {
                        $job->update(['status' => JobStatus::Incomplete]);
                    }
                }

                foreach ($this->city->destinationJobs as $job) {
                    if (!$job->hasPendingGameData) {
                        $job->update(['status' => JobStatus::Incomplete]);
                    }
                }
            }
        }

        return redirect()->route('game-data.cities');
    }

    public function delete()
    {
        if (!$this->city->approved) {
            $this->forgetUnapprovedGameDataCount();

            // Only notify the user if the user still exists
            if ($this->city->requester()->exists()) {
                $this->city->requester->notify(new GameDataRequestDenied($this->city));
            }

            session()->flash('alert', ['type' => 'success', 'message' => 'City request <b>' . $this->city->name . '</b> successfully denied.']);
        } else {
            session()->flash('alert', ['type' => 'success', 'message' => 'City successfully deleted!']);
        }

        try {
            $this->city->delete();
        } catch (QueryException $e) {
            session()->now('alert', ['type' => 'danger', 'message' => 'You can\'t delete this city, it\'s used in a job somewhere!']);

            return;
        }

        return redirect()->route('game-data.cities');
    }

    private function forgetUnapprovedGameDataCount(): void
    {
        Cache::forget('unapproved_game_data_count');
    }
}
