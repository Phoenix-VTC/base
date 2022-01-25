<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Models\Download
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $image_path
 * @property string $file_path
 * @property int $download_count
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $file_name
 * @property-read float|null $file_size
 * @property-read string|null $image_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Revision[] $revisionHistoryWithUser
 * @property-read int|null $revision_history_with_user_count
 * @property-read \App\Models\User $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Download newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Download newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Download query()
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Download extends Model
{
    use HasFactory;
    use RevisionableTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>
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

    public function getFileSizeAttribute(): int|float|null
    {
        try {
            return (int)number_format(Storage::disk('scaleway')->size($this->file_path) / 1048576, 2);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function revisionHistoryWithUser(): MorphMany
    {
        return $this->morphMany(Revision::class, 'revisionable')->with('user');
    }
}
