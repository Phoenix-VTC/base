<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use App\Traits\RevisionUserTrait;

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

    public function scopeLikeSearch($query, $term): Builder
    {
        return $query->where(
            fn($query) => $query->where('usernames', 'like', '%' . $term . '%')
                ->orWhere('emails', 'like', '%' . $term . '%')
                ->orWhere('discord_ids', 'like', '%' . $term . '%')
                ->orWhere('truckersmp_ids', 'like', '%' . $term . '%')
                ->orWhere('steam_ids', 'like', '%' . $term . '%')
        );
    }

    public function scopeExactSearch($query, $term): Builder
    {
        return $query->where(
            fn($query) => $query->whereJsonContains('usernames', $term)
                ->orWhereJsonContains('emails', $term)
                ->orWhereJsonContains('discord_ids', $term)
                ->orWhereJsonContains('truckersmp_ids', $term)
                ->orWhereJsonContains('steam_ids', $term)
        );
    }
}
