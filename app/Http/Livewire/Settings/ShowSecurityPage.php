<?php

namespace App\Http\Livewire\Settings;

use App\Events\PasswordChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ShowSecurityPage extends Component
{
    // Form fields
    public $old_password = '';

    public $new_password = '';

    public $new_password_confirmation = '';

    public string $tracker_token = '******************************************';

    public function rules(): array
    {
        return [
            'old_password' => ['bail', 'required', 'string', 'min:8', 'current_password'],
            'new_password' => ['bail', 'required', 'string', 'min:8', 'confirmed', 'different:old_password'],
            'new_password_confirmation' => ['bail', 'required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'new_password.not_in' => 'The new password must be different than the old password.',
        ];
    }

    public function render()
    {
        return view('livewire.settings.security-page')->extends('layouts.app');
    }

    public function submit()
    {
        $this->validate();

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        event(new PasswordChanged(Auth::user()));

        Auth::logout();

        session()->flash('alert', ['type' => 'success', 'message' => 'Password successfully changed!<br>Please log in again.']);

        return redirect()->route('login');
    }

    public function generateTrackerToken(): void
    {
        $user = Auth::user();

        if ($user->tokens()->where('name', 'tracker-token')->count()) {
            // Delete the existing token
            $user->tokens()->where('name', 'tracker-token')->delete();
        }

        $this->tracker_token = $user->createToken('tracker-token', ['jobs:submit'])->plainTextToken;

        session()->flash('alert', ['type' => 'success', 'message' => 'API Token successfully (re)generated!<br><b>Make sure to copy it before leaving this page.</b>']);
    }

    public function revokeTrackerToken(): void
    {
        Auth::user()->tokens()->where('name', 'tracker-token')->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'API Token successfully revoked!']);
    }

    public function revokeApiToken($id): void
    {
        Auth::user()->tokens()->where('id', $id)->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'API Token successfully revoked!']);
    }

    public function revokeAllApiTokens(): void
    {
        Auth::user()->tokens()->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'All API Tokens successfully revoked!']);
    }
}
