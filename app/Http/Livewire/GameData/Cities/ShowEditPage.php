<?php

namespace App\Http\Livewire\GameData\Cities;

use App\Models\City;
use Illuminate\Database\QueryException;
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

        $this->city->update([
            'real_name' => $this->real_name,
            'name' => $this->name,
            'country' => $this->country,
            'dlc' => $this->dlc,
            'mod' => $this->mod,
            'game_id' => (int)$this->game_id,
            'x' => $this->x ?: null,
            'z' => $this->z ?: null,
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => "City <b>" . $this->city->name . "</b> successfully updated."]);

        return redirect()->route('game-data.cities');
    }

    public function delete()
    {
        try {
            $this->city->delete();

        } catch (QueryException $e) {
            session()->now('alert', ['type' => 'danger', 'message' => 'You can\'t delete this city, it\'s used in a job somewhere!']);

            return;
        }

        session()->flash('alert', ['type' => 'success', 'message' => 'City successfully deleted!']);

        return redirect()->route('game-data.cities');
    }
}
