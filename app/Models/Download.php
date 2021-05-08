<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Download extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getImageUrlAttribute(): string
    {
        return Storage::disk('scaleway')->url($this->image_path);
    }

    public function getFileNameAttribute(): string
    {
        return Str::snake($this->name) . '.' . File::extension($this->file_path);
    }

    public function getFileSizeAttribute(): float
    {
        return number_format(Storage::disk('scaleway')->size($this->file_path) / 1048576, 2);
    }
}
