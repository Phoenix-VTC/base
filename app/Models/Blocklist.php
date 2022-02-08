<?php

namespace App\Models;

use App\Traits\RevisionUserTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Models\Blocklist
 *
 * @property int $id
 * @property array|null $usernames
 * @property array|null $emails
 * @property array|null $discord_ids
 * @property array|null $truckersmp_ids
 * @property array|null $steam_ids
 * @property array|null $base_ids
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Revision[] $revisionHistoryWithUser
 * @property-read int|null $revision_history_with_user_count
 * @method static Builder|Blocklist exactSearch(string $term)
 * @method static \Database\Factories\BlocklistFactory factory(...$parameters)
 * @method static Builder|Blocklist likeSearch(string $term)
 * @method static Builder|Blocklist newModelQuery()
 * @method static Builder|Blocklist newQuery()
 * @method static \Illuminate\Database\Query\Builder|Blocklist onlyTrashed()
 * @method static Builder|Blocklist query()
 * @method static Builder|Blocklist whereBaseIds($value)
 * @method static Builder|Blocklist whereCreatedAt($value)
 * @method static Builder|Blocklist whereDeletedAt($value)
 * @method static Builder|Blocklist whereDiscordIds($value)
 * @method static Builder|Blocklist whereEmails($value)
 * @method static Builder|Blocklist whereId($value)
 * @method static Builder|Blocklist whereReason($value)
 * @method static Builder|Blocklist whereSteamIds($value)
 * @method static Builder|Blocklist whereTruckersmpIds($value)
 * @method static Builder|Blocklist whereUpdatedAt($value)
 * @method static Builder|Blocklist whereUsernames($value)
 * @method static \Illuminate\Database\Query\Builder|Blocklist withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Blocklist withoutTrashed()
 * @mixin \Eloquent
 */
class Blocklist extends Model
{
    use HasFactory;
    use RevisionableTrait;
    use RevisionUserTrait;
    use SoftDeletes;

    protected bool $revisionCreationsEnabled = true;

    protected $casts = [
        'usernames' => 'array',
        'emails' => 'array',
        'discord_ids' => 'array',
        'truckersmp_ids' => 'array',
        'steam_ids' => 'array',
        'base_ids' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $guarded = [];

    public function scopeLikeSearch($query, string $term): Builder
    {
        return $query->where(
            fn ($query) => $query->where('usernames', 'like', '%'.$term.'%')
                ->orWhere('emails', 'like', '%'.$term.'%')
                ->orWhere('discord_ids', 'like', '%'.$term.'%')
                ->orWhere('truckersmp_ids', 'like', '%'.$term.'%')
                ->orWhere('steam_ids', 'like', '%'.$term.'%')
        );
    }

    public function scopeExactSearch($query, string $term): Builder
    {
        return $query->where(
            fn ($query) => $query->whereJsonContains('usernames', $term)
                ->orWhereJsonContains('emails', $term)
                ->orWhereJsonContains('discord_ids', $term)
                ->orWhereJsonContains('truckersmp_ids', $term)
                ->orWhereJsonContains('steam_ids', $term)
        );
    }
}
