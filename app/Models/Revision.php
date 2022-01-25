<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Revision
 *
 * @property int $id
 * @property string $revisionable_type
 * @property int $revisionable_id
 * @property int|null $user_id
 * @property string $key
 * @property string|null $old_value
 * @property string|null $new_value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $revisionable
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Revision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Revision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Revision query()
 * @method static \Illuminate\Database\Eloquent\Builder|Revision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Revision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Revision whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Revision whereNewValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Revision whereOldValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Revision whereRevisionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Revision whereRevisionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Revision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Revision whereUserId($value)
 * @mixin \Eloquent
 */
class Revision extends \Venturecraft\Revisionable\Revision
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
