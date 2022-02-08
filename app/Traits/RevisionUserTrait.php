<?php

namespace App\Traits;

use App\Models\Revision;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Venturecraft\Revisionable\RevisionableTrait;

trait RevisionUserTrait
{
    public function revisionHistoryWithUser(): MorphMany
    {
        return $this->morphMany(Revision::class, 'revisionable')->with('user');
    }

    public function firstEditor(): ?User
    {
        return $this->revisionHistoryWithUser()->first()->user;
    }

    public function latestEditor(): ?User
    {
        return $this->revisionHistoryWithUser()->latest()->first()->user;
    }
}
