<?php

namespace App\Http\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ShowPreferencesPage extends Component
{
    public User $user;
    // Form fields
    public string $preferred_distance = '';
    public string $preferred_currency = '';
    public string $preferred_weight = '';

    public function rules(): array
    {
        return [
            'preferred_distance' => ['required', Rule::in(['kilometres', 'miles'])],
            'preferred_currency' => ['required', Rule::in(['euro', 'dollar'])],
            'preferred_weight' => ['required', Rule::in(['tonnes', 'pounds'])],
        ];
    }

    public function mount(): void
    {
        $this->user = Auth::user();

        $this->preferred_distance = $this->user->settings()->get('preferences.distance');
        $this->preferred_currency = $this->user->settings()->get('preferences.currency');
        $this->preferred_weight = $this->user->settings()->get('preferences.weight');
    }

    public function render(): View
    {
        return view('livewire.settings.preferences-page')->extends('layouts.app');
    }

    public function submit(): void
    {
        $validatedData = $this->validate();

        $this->user->settings()->setMultiple([
            'preferences.distance' => $validatedData['preferred_distance'],
            'preferences.currency' => $validatedData['preferred_currency'],
            'preferences.weight' => $validatedData['preferred_weight'],
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Settings successfully updated!']);
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }
}
