<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get all the users.
     */
    public function all(): Collection;
}
