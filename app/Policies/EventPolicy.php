<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the event management overview page.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage events');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Event $event
     * @return Response|bool
     */
    public function view(User $user, Event $event)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->can('manage events');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Event $event
     * @return Response|bool
     */
    public function update(User $user, Event $event)
    {
        return $user->can('manage events');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Event $event
     * @return Response|bool
     */
    public function delete(User $user, Event $event)
    {
        return $user->can('manage events');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Event $event
     * @return Response|bool
     */
    public function restore(User $user, Event $event)
    {
        return $user->can('manage events');
    }
}
