<?php

namespace App\Traits;

trait HasRoleLevelTrait
{
    public function roleLevel(): int
    {
        // Get all the roles assigned to the user, pluck the level column, convert that to an array, and get the "highest" array item.
        return max($this->roles->pluck('level')->toArray() ?: [0]);
    }
}
