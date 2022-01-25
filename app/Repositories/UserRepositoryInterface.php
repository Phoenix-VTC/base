<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get all the users.
     */
    public function all(): Collection;

    /**
     * Create a new record of the user.
     *
     * @param  array  $attributes
     * @return User
     */
    public function create(array $attributes): User;
}
