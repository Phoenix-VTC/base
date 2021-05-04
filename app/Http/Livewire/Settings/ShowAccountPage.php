<?php

namespace App\Http\Livewire\Settings;

use App\Models\User;
use App\Rules\UsernameNotReserved;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowAccountPage extends Component
{
    public User $user;
    // Form fields
    public string $username = '';
    public string $email = '';
    public string $steam_id = '';
    public string $truckersmp_id = '';
    public string $date_of_birth = '';

    public function rules(): array
    {
        return [
            'username' => ['required', 'min:3', 'unique:users,username,' . $this->user->id, new UsernameNotReserved],
            'email' => ['required', 'min:3', 'email', 'unique:users,email,' . $this->user->id],
        ];
    }

    public function mount(): void
    {
        $this->user = Auth::user();

        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->steam_id = $this->user->steam_id;
        $this->truckersmp_id = $this->user->truckersmp_id;
        $this->date_of_birth = $this->user->date_of_birth;
    }

    public function render()
    {
        return view('livewire.settings.account-page')->extends('layouts.app');
    }

    public function submit(): void
    {
        $this->validate();

        $this->user->update([
            'username' => $this->username,
            'email' => $this->email,
        ]);

        session()->now('alert', ['type' => 'success', 'message' => 'Account successfully updated!']);
    }
}
