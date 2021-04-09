<?php

namespace App\Http\Livewire\GameData\Companies;

use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ShowIndexPage extends Component
{
    public string $name = '';
    public string $category = '';
    public string $specialization = '';
    public string $dlc = '';
    public string $mod = '';
    public string $game_id = '1';

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'category' => ['sometimes'],
            'specialization' => ['sometimes'],
            'dlc' => ['sometimes'],
            'mod' => ['sometimes'],
            'game_id' => ['required', 'integer', Rule::in(['1', '2'])],
        ];
    }

    public function render(): View
    {
        return view('livewire.game-data.companies')
            ->extends('layouts.app');
    }

    public function submit(): void
    {
        $this->validate();

        $company = Company::create([
            'name' => $this->name,
            'category' => $this->category,
            'specialization' => $this->specialization,
            'dlc' => $this->dlc,
            'mod' => $this->mod,
            'game_id' => (int)$this->game_id,
        ]);

        $this->reset();

        session()->flash('alert', ['type' => 'success', 'message' => "Company <b>$company->name</b> successfully added."]);
    }
}
