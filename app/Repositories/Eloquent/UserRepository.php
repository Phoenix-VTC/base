<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Construct the UserRepository class with a user.
     *
     * @param  User  $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /** {@inheritdoc} */
    public function all(): Collection
    {
        return $this->model::all();
    }

    /** {@inheritdoc} */
    public function create(array $attributes): User
    {
        return $this->model::create($attributes);
    }
}
