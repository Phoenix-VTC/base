<?php

namespace App\Http\Livewire\GameData\Cities;

use App\Models\City;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ShowIndexPage extends Component
{
    public string $real_name = '';
    public string $name = '';
    public string $country = '';
    public string $dlc = '';
    public string $mod = '';
    public string $game_id = '1';
    public string $x = '';
    public string $z = '';

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

    public function render(): View
    {
        return view('livewire.game-data.cities')
            ->extends('layouts.app');
    }

    public function submit(): void
    {
        $this->validate();

        $city = City::create([
            'real_name' => $this->real_name,
            'name' => $this->name,
            'country' => $this->country,
            'dlc' => $this->dlc,
            'mod' => $this->mod,
            'game_id' => (int)$this->game_id,
            'x' => $this->x ?: null,
            'z' => $this->z ?: null,
        ]);

        $this->reset();

        session()->now('alert', ['type' => 'success', 'message' => "City <b>$city->real_name</b> successfully added."]);
    }
}
