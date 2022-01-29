<?php
namespace App\Models;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string|null $identifier
 * @property string $name
 * @property string $badge_color
 * @property string $text_color
 * @property string $guard_name
 * @property int $level
 * @property bool $is_staff
 * @property bool $is_upper_staff
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Alexmg86\LaravelSubQuery\Collection\LaravelSubQueryCollection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereBadgeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereIsStaff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereIsUpperStaff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends SpatieRole
{
    protected $casts = [
        'is_staff' => 'boolean',
        'is_upper_staff' => 'boolean',
    ];
}
