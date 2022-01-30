<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can claim the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return bool
     */
    public function claim(User $user, Application $application): bool
    {
        return $user->can('handle driver applications');
    }

    /**
     * Determine whether the user can update the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return bool
     */
    public function update(User $user, Application $application): bool
    {
        return $application->claimed_by === $user->id;
    }

    /**
     * Determine whether the user can add the applicant to the blocklist.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return bool
     */
    public function blocklist(User $user, Application $application): bool
    {
        return $user->can('handle driver applications') && $user->can('create blocklist') && $application->claimed_by === $user->id;
    }
}
