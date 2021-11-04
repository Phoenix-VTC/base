<?php

namespace App\Http\Livewire\Settings;

use App\Achievements\UserSetAProfileBanner;
use App\Achievements\UserSetAProfilePicture;
use App\Events\EmailChanged;
use App\Models\User;
use App\Rules\UsernameNotReserved;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowAccountPage extends Component
{
    use WithFileUploads;

    public User $user;
    // Form fields
    public $username = '';
    public $email = '';
    public ?string $steam_id = '';
    public ?string $truckersmp_id = '';
    public ?string $date_of_birth = '';
    public $profile_picture;
    public $profile_banner;

    public function rules(): array
    {
        return [
            'username' => ['bail', 'string', 'required', 'min:3', Rule::unique('users')->whereNull('deleted_at')->ignore($this->user->id), new UsernameNotReserved],
            'email' => ['bail', 'string', 'required', 'min:3', 'email', Rule::unique('users')->whereNull('deleted_at')->ignore($this->user->id)],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
            'profile_banner' => ['nullable', 'image', 'max:2048'],
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

        if ($this->profile_picture) {
            Storage::disk('scaleway')->delete($this->user->profile_picture_path);
            $profile_picture = $this->profile_picture->storePublicly('user/' . $this->user->id, 'scaleway');

            $this->user->unlock(new UserSetAProfilePicture());
        }

        if ($this->profile_banner) {
            Storage::disk('scaleway')->delete($this->user->profile_banner_path);
            $profile_banner = $this->profile_banner->storePublicly('user/' . $this->user->id, 'scaleway');

            $this->user->unlock(new UserSetAProfileBanner());
        }

        if ($this->email !== $this->user->email) {
            event(new EmailChanged($this->user));
        }

        $this->user->update([
            'profile_picture_path' => $profile_picture ?? $this->user->profile_picture_path,
            'profile_banner_path' => $profile_banner ?? $this->user->profile_banner_path,
            'username' => $this->username,
            'email' => $this->email,
        ]);

        session()->now('alert', ['type' => 'success', 'message' => 'Account successfully updated!']);
    }

    public function removeProfilePicture(): void
    {
        Storage::disk('scaleway')->delete($this->user->profile_picture_path);
        $this->user->update(['profile_picture_path' => null]);

        session()->now('alert', ['type' => 'success', 'message' => 'Profile picture successfully removed!']);
    }

    public function removeProfileBanner(): void
    {
        Storage::disk('scaleway')->delete($this->user->profile_banner_path);
        $this->user->update(['profile_banner_path' => null]);

        session()->now('alert', ['type' => 'success', 'message' => 'Profile banner successfully removed!']);
    }
}
