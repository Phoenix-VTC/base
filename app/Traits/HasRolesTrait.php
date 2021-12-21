<?php

namespace App\Traits;

use Spatie\Permission\Traits\HasRoles as SpatieHasRoles;

trait HasRolesTrait
{
    use SpatieHasRoles;

    public function roleLevel(): int
    {
        // Get all the roles assigned to the user, pluck the level column, convert that to an array, and get the "highest" array item.
        return max($this->roles->pluck('level')->toArray() ?: [0]);
    }

    public function isStaff(): bool
    {
        return $this->roles->where('is_staff', true)->count() > 0;
    }

    public function isUpperStaff(): bool
    {
        return $this->roles->where('is_upper_staff', true)->count() > 0;
    }

    public function isSuperAdmin(): bool
    {
        return $this->roles->where('name', 'super admin')->count() > 0;
    }
}
