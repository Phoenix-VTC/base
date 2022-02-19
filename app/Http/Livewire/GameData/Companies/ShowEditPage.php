<?php

namespace App\Http\Livewire\GameData\Companies;

use App\Enums\JobStatus;
use App\Models\Company;
use App\Notifications\GameDataRequestApproved;
use App\Notifications\GameDataRequestDenied;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Throwable;

/**
 * @property Forms\ComponentContainer $form
 */
class ShowEditPage extends Component implements HasForms
{
    use AuthorizesRequests;
    use InteractsWithForms;

    public Company $company;

    public $name;
    public $category;
    public $specialization;
    public $dlc;
    public $mod;
    public $game_id = 1;

    public function mount(): void
    {
        $this->authorize('update', $this->company);

        $this->form->fill([
            'name' => $this->company->name,
            'category' => $this->company->category,
            'specialization' => $this->company->specialization,
            'dlc' => $this->company->dlc,
            'mod' => $this->company->mod,
            'game_id' => $this->company->game_id,
        ]);
    }

    public function render()
    {
        return view('livewire.game-data.companies-edit')->extends('layouts.app');
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
                                ->required()
                        ]),
                ]),
        ];
    }

    public function submit()
    {
        $validatedData = $this->form->getState();

        if (!$this->company->approved) {
            $this->forgetUnapprovedGameDataCount();

            session()->flash('alert', ['type' => 'success', 'message' => 'Company request <b>' . $this->company->name . '</b> successfully approved.']);

            // Only notify the user if the user still exists
            if ($this->company->requester()->exists()) {
                $this->company->requester->notify(new GameDataRequestApproved($this->company));
            }

            $approved = true;
        } else {
            session()->flash('alert', ['type' => 'success', 'message' => 'Company <b>' . $this->company->name . '</b> successfully updated.']);
        }

        $this->company->update([
            'name' => $validatedData['name'],
            'category' => $validatedData['category'],
            'specialization' => $validatedData['specialization'],
            'dlc' => $validatedData['dlc'],
            'mod' => $validatedData['mod'],
            'game_id' => $validatedData['game_id'],
            'approved' => true,
        ]);

        if (($approved ?? false)) {
            // If the pending company has jobs attached, loop through those jobs
            // and change the status to incomplete if those jobs don't have any pending game data
            if ($this->company->pickupJobs->count() || $this->company->destinationJobs->count()) {
                foreach ($this->company->pickupJobs as $job) {
                    if (!$job->hasPendingGameData()) {
                        $job->update(['status' => JobStatus::Incomplete]);
                    }
                }

                foreach ($this->company->destinationJobs as $job) {
                    if (!$job->hasPendingGameData()) {
                        $job->update(['status' => JobStatus::Incomplete]);
                    }
                }
            }
        }

        return redirect()->route('game-data.companies');
    }

    public function delete()
    {
        if (!$this->company->approved) {
            $this->forgetUnapprovedGameDataCount();

            // Only notify the user if the user still exists
            if ($this->company->requester()->exists()) {
                $this->company->requester->notify(new GameDataRequestDenied($this->company));
            }

            session()->flash('alert', ['type' => 'success', 'message' => 'Company request <b>' . $this->company->name . '</b> successfully denied.']);
        } else {
            session()->flash('alert', ['type' => 'success', 'message' => 'Company successfully deleted!']);
        }

        try {
            $this->company->deleteOrFail();
        } catch (Throwable) {
            session()->now('alert', ['type' => 'danger', 'message' => 'You can\'t delete this company, it\'s used in a job somewhere!']);

            return;
        }

        return redirect()->route('game-data.companies');
    }

    private function forgetUnapprovedGameDataCount(): void
    {
        Cache::forget('unapproved_game_data_count');
    }
}
