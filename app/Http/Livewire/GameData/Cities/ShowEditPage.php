<?php

namespace App\Http\Livewire\GameData\Cities;

use App\Enums\JobStatus;
use App\Models\City;
use App\Notifications\GameDataRequestApproved;
use App\Notifications\GameDataRequestDenied;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ShowEditPage extends Component
{
    public City $city;

    public string $real_name = '';
    public string $name = '';
    public string $country = '';
    public ?string $dlc = '';
    public ?string $mod = '';
    public string $game_id = '1';
    public ?string $x = '';
    public ?string $z = '';

    public function rules(): array
    {
        return [
            'real_name' => ['required'],
            'name' => ['required'],
            'country' => ['required'],
            'dlc' => ['sometimes'],
            'mod' => ['sometimes'],
            'game_id' => ['required', 'integer', Rule::in(['1', '2'])],
            'x' => ['sometimes', 'integer'],
            'z' => ['sometimes', 'integer'],
        ];
    }

    public function mount(): void
    {
        $this->fill([
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

    public function render(): View
    {
        return view('livewire.game-data.cities-edit')
            ->extends('layouts.app');
    }

    public function submit()
    {
        $this->validate();

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
            'real_name' => $this->real_name,
            'name' => $this->name,
            'country' => $this->country,
            'dlc' => $this->dlc,
            'mod' => $this->mod,
            'game_id' => (int)$this->game_id,
            'x' => $this->x ?: null,
            'z' => $this->z ?: null,
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
