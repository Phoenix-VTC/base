<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VacationRequest;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class VacationRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any vacation request.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->cannot('manage vacation requests');
    }

    /**
     * Determine whether the user can update the vacation request.
     *
     * @param User $user
     * @param VacationRequest $vacationRequest
     * @return Response
     */
    public function update(User $user, VacationRequest $vacationRequest): Response
    {
        if ($user->cannot('manage vacation requests')) {
            return Response::deny();
        }

        if ($vacationRequest->deleted_at) {
            return Response::deny('This vacation request has already been cancelled.');
        }

        if ($vacationRequest->is_expired) {
            return Response::deny('This vacation request has already expired.');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can mark the vacation request as seen.
     *
     * @param User $user
     * @param VacationRequest $vacationRequest
     * @return Response
     */
    public function markAsSeen(User $user, VacationRequest $vacationRequest): Response
    {
        $canUpdate = $this->update($user, $vacationRequest);

        if ($canUpdate->denied()) {
            return $canUpdate;
        }

        if ($vacationRequest->handled_by) {
            return Response::deny('This vacation request has already been handled.');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can cancel the vacation request.
     *
     * @param User $user
     * @param VacationRequest $vacationRequest
     * @return Response
     */
    public function cancel(User $user, VacationRequest $vacationRequest): Response
    {
        return $this->update($user, $vacationRequest);
    }
}
