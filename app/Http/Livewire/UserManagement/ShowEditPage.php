<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use App\Rules\UsernameNotReserved;
use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ShowEditPage extends Component
{
    use AuthorizesRequests;

    public User $user;
    public array $available_roles;
    // Form fields
    public $username = '';
    public $email = '';
    public string $steam_id = '';
    public string $truckersmp_id = '';
    public string $date_of_birth = '';
    public array $user_roles = [];

    public function mount(int $id): void
    {
        $this->user = User::with([
            'roles',
        ])->findOrFail($id);

        $this->authorize('update', $this->user);

        $this->available_roles = Role::query()
            ->where('level', '<=', Auth::user()->roleLevel())
            ->pluck('name', 'id')
            ->toArray();

        // Form fields
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->steam_id = $this->user->steam_id ?? '';
        $this->truckersmp_id = $this->user->truckersmp_id ?? '';
        $this->date_of_birth = $this->user->date_of_birth ?? '';
        $this->user_roles = $this->user->roles->pluck('id')->toArray();
    }

    public function rules(): array
    {
        return [
            'username' => ['bail', 'required', 'string', 'min:3', 'unique:users,username,' . $this->user->id, new UsernameNotReserved],
            'email' => ['bail', 'required', 'string', 'email', 'unique:users,email,' . $this->user->id],
            'steam_id' => 'required|numeric',
            'truckersmp_id' => 'required|numeric',
            'date_of_birth' => 'required|date|before_or_equal:' . Carbon::now()->subYears(16),
            'user_roles' => 'required|array'
        ];
    }

    public function render()
    {
        return view('livewire.user-management.edit-page')->extends('layouts.app');
    }

    public function submit()
    {
        $this->validate();

        $this->user->update([
            'username' => $this->username,
            'email' => $this->email,
            'steam_id' => $this->steam_id,
            'truckersmp_id' => $this->truckersmp_id,
            'date_of_birth' => $this->date_of_birth,
        ]);

        $this->user->syncRoles($this->user_roles);

        session()->flash('alert', ['type' => 'success', 'message' => 'Profile successfully updated!']);

        return redirect(route('users.profile', $this->user));
    }
}
