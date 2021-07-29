<?php

namespace App\Http\Livewire\Jobs;

use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ShowRequestGameDataPage extends Component
{
    public string $type = '';
    public string $game_id = '';
    public string $real_name = '';
    public string $category = '';
    public string $specialization = '';
    public string $country = '';
    public string $dlc = '';
    public string $mod = '';
    public string $weight = '';
    public string $wot = '';
    public string $x = '';
    public string $z = '';

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['city', 'company', 'cargo'])],
            'game_id' => ['required', 'integer', Rule::in(['1', '2'])],
            'real_name' => ['required'],
            'category' => ['exclude_unless:type,company', 'required'],
            'specialization' => ['exclude_unless:type,company', 'required'],
            'country' => ['exclude_unless:type,city', 'required'],
            'dlc' => ['sometimes', 'string'],
            'mod' => ['sometimes', 'string'],
            'weight' => ['sometimes', 'numeric', 'min:1'],
            'wot' => ['exclude_unless:type,cargo', 'required', 'boolean'],
            'x' => ['sometimes', 'integer'],
            'z' => ['sometimes', 'integer'],
        ];
    }

    protected array $validationAttributes = [
        'wot' => 'World of Trucks'
    ];

    public function render()
    {
        return view('livewire.jobs.show-request-game-data-page')->extends('layouts.app');
    }

    public function submit(): void
    {
        $this->validate();

        switch ($this->type) {
            case 'city':
                City::create([
                    'real_name' => $this->real_name,
                    'name' => Str::snake($this->real_name),
                    'country' => $this->country,
                    'dlc' => $this->dlc,
                    'mod' => $this->mod,
                    'game_id' => (int)$this->game_id,
                    'x' => $this->x ?: null,
                    'z' => $this->z ?: null,
                    'approved' => false,
                    'requested_by' => Auth::id(),
                ]);
                break;
            case 'company':
                Company::create([
                    'name' => $this->real_name,
                    'category' => $this->category,
                    'specialization' => $this->specialization,
                    'dlc' => $this->dlc,
                    'mod' => $this->mod,
                    'game_id' => (int)$this->game_id,
                    'approved' => false,
                    'requested_by' => Auth::id(),
                ]);
                break;
            case 'cargo':
                Cargo::create([
                    'name' => $this->real_name,
                    'dlc' => $this->dlc,
                    'mod' => $this->mod,
                    'weight' => (int)$this->weight,
                    'game_id' => (int)$this->game_id,
                    'world_of_trucks' => (bool)$this->wot,
                    'approved' => false,
                    'requested_by' => Auth::id(),
                ]);
                break;
        }

        session()->now('alert', ['type' => 'success', 'message' => ucfirst($this->type) . " <b>$this->real_name</b> successfully requested.<br>You will receive a notification on the Base when your request has been approved or denied."]);

        $this->reset();
    }
}
