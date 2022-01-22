<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function removeProfilePicture(User $user): RedirectResponse
    {
        Storage::disk('scaleway')->delete($user->profile_picture_path);
        $user->update(['profile_picture_path' => null]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Profile picture successfully removed!']);

        return redirect()->route('users.edit', [$user]);
    }

    public function removeProfileBanner(User $user): RedirectResponse
    {
        Storage::disk('scaleway')->delete($user->profile_banner_path);
        $user->update(['profile_banner_path' => null]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Profile banner successfully removed!']);

        return redirect()->route('users.edit', $user);
    }
}
