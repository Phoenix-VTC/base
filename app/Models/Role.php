<?php
namespace App\Models;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $casts = [
        'is_staff' => 'boolean',
        'is_upper_staff' => 'boolean',
    ];
}
