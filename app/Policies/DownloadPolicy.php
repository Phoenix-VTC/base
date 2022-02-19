<?php

namespace App\Policies;

use App\Models\Download;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DownloadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can download the model.
     *
     * @param User $user
     * @param Download $download
     * @return bool
     */
    public function download(User $user, Download $download): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the download management page.
     *
     * @param User $user
     * @return bool
     */
    public function viewManagement(User $user): bool
    {
        return $user->can('manage downloads');
    }

    /**
     * Determine whether the user can view the model's revision history.
     *
     * @param User $user
     * @return bool
     */
    public function viewRevisionHistory(User $user): bool
    {
        return $user->can('manage downloads');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('manage downloads');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Download $download
     * @return bool
     */
    public function update(User $user, Download $download): bool
    {
        return $user->can('manage downloads');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Download $download
     * @return bool
     */
    public function delete(User $user, Download $download): bool
    {
        return $user->can('manage downloads');
    }
}
