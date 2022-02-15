<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

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
     * @return Response
     */
    public function update(User $user, Application $application): Response
    {
        return ($application->claimed_by === $user->id)
            ? Response::allow()
            : Response::deny('You need to claim this application before you can update it.');
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
