<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Venturecraft\Revisionable\RevisionableTrait;

class Download extends Model
{
    use HasFactory;
    use RevisionableTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected array $dontKeepRevisionOf = ['download_count'];

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getImageUrlAttribute(): ?string
    {
        try {
            return Storage::disk('scaleway')->url($this->image_path);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getFileNameAttribute(): string
    {
        return str_replace(' ', '_', $this->name) . '.' . File::extension($this->file_path);
    }

    public function getFileSizeAttribute(): ?float
    {
        try {
            return number_format(Storage::disk('scaleway')->size($this->file_path) / 1048576, 2);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function revisionHistoryWithUser(): MorphMany
    {
        return $this->morphMany(Revision::class, 'revisionable')->with('user');
    }
}
