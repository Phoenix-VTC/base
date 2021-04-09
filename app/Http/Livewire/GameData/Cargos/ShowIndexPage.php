<?php

namespace App\Http\Livewire\GameData\Cargos;

use App\Models\Cargo;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ShowIndexPage extends Component
{
    public string $name = '';
    public string $dlc = '';
    public string $mod = '';
    public string $weight = '';
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

    public function render(): View
    {
        return view('livewire.game-data.cargos')
            ->extends('layouts.app');
    }

    public function submit(): void
    {
        $this->validate();

        $cargo = Cargo::create([
            'name' => $this->name,
            'dlc' => $this->dlc,
            'mod' => $this->mod,
            'weight' => (int)$this->weight,
            'game_id' => (int)$this->game_id,
            'world_of_trucks' => (bool)$this->wot,
        ]);

        $this->reset();

        session()->flash('alert', ['type' => 'success', 'message' => "Cargo <b>$cargo->name</b> successfully added."]);
    }
}
