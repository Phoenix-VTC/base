<?php

namespace App\Models;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Screenshot
 *
 * @property int $id
 * @property int $user_id
 * @property string $image_path
 * @property string $title
 * @property string|null $description
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string|null $image_url
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vote[] $votes
 * @property-read int|null $votes_count
 * @method static \Alexmg86\LaravelSubQuery\Collection\LaravelSubQueryCollection|static[] all($columns = ['*'])
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot castColumn($column, $type = null)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot eagerLoadRelationsOne(array $models, string $type)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot forceIndex($column)
 * @method static \Alexmg86\LaravelSubQuery\Collection\LaravelSubQueryCollection|static[] get($columns = ['*'])
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot like($column, $value, $condition = false)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot likeLeft($column, $value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot likeRight($column, $value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot newModelQuery()
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot newQuery()
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot orderByRelation($relations, $orderType = 'desc', $type = 'max')
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot query()
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot setWithAvg($withAvg)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot setWithMax($withMax)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot setWithMin($withMin)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot setWithSum($withSum)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot whereCreatedAt($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot whereCurrentDay($column = 'created_at')
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot whereCurrentMonth($column = 'created_at')
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot whereCurrentYear($column = 'created_at')
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot whereDescription($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot whereId($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot whereImagePath($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot whereLocation($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot whereTitle($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot whereUpdatedAt($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot whereUserId($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|Screenshot withMath($columns, $operator = '+', $name = null)
 * @mixin \Eloquent
 */
class Screenshot extends Model
{
    use LaravelSubQueryTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = [];

    /**
     * Get the user that owns the screenshot.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the screenshot's votes.
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function getImageUrlAttribute(): ?string
    {
        try {
            return Storage::disk('scaleway')->url($this->image_path);
        } catch (\Exception $e) {
            return null;
        }
    }
}
