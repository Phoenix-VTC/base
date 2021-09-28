<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Blocklist extends Model
{
    use HasFactory;
    use RevisionableTrait;

    protected bool $revisionCreationsEnabled = true;

    protected $casts = [
        'usernames' => 'array',
        'emails' => 'array',
        'discord_ids' => 'array',
        'truckersmp_ids' => 'array',
        'steam_ids' => 'array',
    ];

    protected $guarded = [];
}
