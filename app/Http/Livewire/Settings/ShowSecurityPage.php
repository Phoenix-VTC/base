<?php

namespace App\Http\Livewire\Settings;

use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ShowSecurityPage extends Component
{
    // Form fields
    public string $old_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function rules(): array
    {
        return [
            'old_password' => ['required', 'min:8', new MatchOldPassword],
            'new_password' => ['required', 'min:8', 'confirmed', 'not_in:' . $this->old_password],
        ];
    }

    public function messages(): array
    {
        return [
            'new_password.not_in' => 'The new password must be different than the old password.'
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
            'password' => Hash::make($this->new_password)
        ]);

        Auth::logout();

        session()->flash('alert', ['type' => 'success', 'message' => 'Password successfully changed!<br>Please log in again.']);

        return redirect()->route('login');
    }
}
