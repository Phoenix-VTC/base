<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage users');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool|Response
     */
    public function update(User $user, User $model): bool|Response
    {
        // Check if the user can manage users
        if ($user->cannot('manage users')) {
            return false;
        }

        // Check if the user is trying to update staff, excluding themselves
        if ($user->id !== $model->id && $model->isStaff() && !$user->isUpperStaff()) {
            return Response::deny('You cannot update staff.');
        }

        // Check if the user is trying to update upper staff, excluding themselves
        if ($user->id !== $model->id && $model->isUpperStaff() && !$user->isSuperAdmin()) {
            return Response::deny('You cannot update upper staff.');
        }

        // Check if the user's role level is higher than the model's role level
        if ($user->roleLevel() > $model->roleLevel()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        return $user->can('delete users') &&
            $user->roleLevel() > $model->roleLevel() &&
            $user->id !== $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function restore(User $user, User $model): bool
    {
        return $user->can('delete users') &&
            $user->roleLevel() > $model->roleLevel();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->can('delete users') &&
            $user->roleLevel() > $model->roleLevel() &&
            $user->id !== $model->id;
    }
}
