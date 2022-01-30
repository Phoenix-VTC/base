<?php

namespace App\Policies;

use App\Models\Blocklist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlocklistPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view blocklist');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Blocklist  $blocklist
     * @return bool
     */
    public function view(User $user, Blocklist $blocklist)
    {
        return $user->can('view blocklist');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('create blocklist');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Blocklist  $blocklist
     * @return bool
     */
    public function update(User $user, Blocklist $blocklist)
    {
        return $user->can('create blocklist');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Blocklist  $blocklist
     * @return bool
     */
    public function delete(User $user, Blocklist $blocklist)
    {
        return $user->can('delete blocklist');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Blocklist  $blocklist
     * @return bool
     */
    public function restore(User $user, Blocklist $blocklist)
    {
        return $user->can('delete blocklist');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Blocklist  $blocklist
     * @return bool
     */
    public function forceDelete(User $user, Blocklist $blocklist)
    {
        return $user->can('delete blocklist');
    }
}
