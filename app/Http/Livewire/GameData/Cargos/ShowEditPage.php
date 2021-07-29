<?php

namespace App\Http\Livewire\GameData\Cargos;

use App\Models\Cargo;
use App\Notifications\GameDataRequestApproved;
use App\Notifications\GameDataRequestDenied;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ShowEditPage extends Component
{
    public Cargo $cargo;

    public string $name = '';
    public ?string $dlc = '';
    public ?string $mod = '';
    public ?string $weight = '';
    public string $game_id = '1';
    public string $wot = '0';

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'dlc' => ['sometimes'],
            'mod' => ['sometimes'],
            'weight' => ['sometimes', 'numeric', 'min:1'],
            'game_id' => ['required', 'integer', Rule::in(['1', '2'])],
            'wot' => ['required', 'boolean'],
        ];
    }

    public function mount(): void
    {
        $this->fill([
            'name' => $this->cargo->name,
            'dlc' => $this->cargo->dlc,
            'mod' => $this->cargo->mod,
            'weight' => $this->cargo->weight,
            'game_id' => $this->cargo->game_id,
            'wot' => $this->cargo->world_of_trucks,
        ]);
    }

    public function render(): View
    {
        return view('livewire.game-data.cargos-edit')
            ->extends('layouts.app');
    }

    public function submit()
    {
        $this->validate();

        if (!$this->cargo->approved) {
            $this->forgetUnapprovedGameDataCount();

            session()->flash('alert', ['type' => 'success', 'message' => 'Cargo request <b>' . $this->cargo->name . '</b> successfully approved.']);

            // Only notify the user if the user still exists
            if ($this->cargo->requester()->exists()) {
                $this->cargo->requester->notify(new GameDataRequestApproved($this->cargo));
            }
        } else {
            session()->flash('alert', ['type' => 'success', 'message' => 'Cargo <b>' . $this->cargo->name . '</b> successfully updated.']);
        }

        $this->cargo->update([
            'name' => $this->name,
            'dlc' => $this->dlc,
            'mod' => $this->mod,
            'weight' => (int)$this->weight,
            'game_id' => (int)$this->game_id,
            'world_of_trucks' => (bool)$this->wot,
            'approved' => true,
        ]);

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
            $this->cargo->delete();
        } catch (QueryException $e) {
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
