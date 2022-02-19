<?php

namespace App\Policies;

use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Job $job
     * @return Response
     */
    public function view(User $user, Job $job): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response
     */
    public function create(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Job $job
     * @return Response
     */
    public function update(User $user, Job $job): Response
    {
        // Allow if the user can manage users
        if ($user->can('manage users')) {
            return Response::allow();
        }

        // Deny if the job is pending verification
        if ($job->status->value === JobStatus::PendingVerification) {
            return Response::deny('You cannot edit a job that is pending verification.');
        }

        // Deny if the job is incomplete
        if ($job->status->value === JobStatus::Incomplete) {
            return Response::deny('You cannot edit a job that is incomplete.');
        }

        // Allow if the user owns the job, and an hour since submission hasn't passed
        if ($job->user_id === $user->id && $job->submittedAt()->diffInHours() < 1) {
            return Response::allow();
        }

        return Response::deny('You do not have permission to update this job.');
    }

    /**
     * Determine whether the user can verify the job.
     *
     * @param User $user
     * @param Job $job
     * @return bool
     */
    public function verify(User $user, Job $job): bool
    {
        return $job->tracker_job &&
            $job->user_id === $user->id &&
            $job->status->value === JobStatus::Incomplete;
    }

    /**
     * Determine whether the user can manually approve the job.
     *
     * @param User $user
     * @param Job $job
     * @return bool
     */
    public function approve(User $user, Job $job): bool
    {
        // Allow if the job is pending verification, and the user can manage users
        return $job->status->value === JobStatus::PendingVerification && $user->can('manage users');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Job $job
     * @return Response
     */
    public function delete(User $user, Job $job): Response
    {
        // Allow if the user can manage users
        if ($user->can('manage users')) {
            return Response::allow();
        }

        // Allow if the job is pending verification or incomplete
        if (in_array($job->status->value, [JobStatus::PendingVerification, JobStatus::Incomplete], true)) {
            return Response::allow();
        }

        // Allow if the user owns the job, and an hour since submission hasn't passed
        if ($job->user_id === $user->id && $job->submittedAt()->diffInHours() < 1) {
            return Response::allow();
        }

        return Response::deny('You do not have permission to delete this job.');
    }
}
