<?php

namespace App\Policies;

use App\Models\Screenshot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ScreenshotPolicy
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
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Screenshot $screenshot
     * @return bool
     */
    public function view(User $user, Screenshot $screenshot): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        $screenshot = Screenshot::where('user_id', $user->id)->where('created_at', '>', Carbon::parse('-24 hours'))->first();

        if ($screenshot) {
            return Response::deny("You have already submitted a screenshot within the last 24 hours. You can submit a new screenshot in {$screenshot->created_at->addDay()->diffForHumans()}.");
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Screenshot $screenshot
     * @return bool
     */
    public function delete(User $user, Screenshot $screenshot): bool
    {
        return $user->id === $screenshot->user_id || $user->can('manage screenshots');
    }
}
