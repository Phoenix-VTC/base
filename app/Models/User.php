<?php

namespace App\Models;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use App\Traits\HasRolesTrait;
use Assada\Achievements\Achiever;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWallets;
use Glorand\Model\Settings\Traits\HasSettingsTable;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;
use Syntax\SteamApi\Client as SteamClient;
use Syntax\SteamApi\Containers\Player;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $slug
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property int|null $steam_id
 * @property int|null $truckersmp_id
 * @property array|null $discord
 * @property string|null $date_of_birth
 * @property string $password
 * @property string|null $last_ip_address
 * @property int|null $application_id
 * @property string|null $profile_picture_path
 * @property string|null $profile_banner_path
 * @property int|float $driver_level
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $welcome_valid_until
 * @property string|null $welcome_token
 * @property-read \App\Models\Application|null $application
 * @property-read float|int|string $balance
 * @property-read int $balance_int
 * @property-read int $default_wallet_balance
 * @property-read int|float $next_driver_level_distance
 * @property-read int|float $percentage_until_driver_level_up
 * @property-read string|null $preferred_currency_symbol
 * @property-read string $preferred_distance_abbreviation
 * @property-read string $profile_banner
 * @property-read string $profile_picture
 * @property-read string|null $qualified_preferred_distance
 * @property-read int|float $required_distance_until_next_level
 * @property-read \Syntax\SteamApi\Containers\Player|null $steam_player_summary
 * @property-read array $truckers_mp_data
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $jobs
 * @property-read int|null $jobs_count
 * @property-read \Glorand\Model\Settings\Models\ModelSettings|null $modelSettings
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Revision[] $revisionHistoryWithUser
 * @property-read int|null $revision_history_with_user_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bavix\Wallet\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bavix\Wallet\Models\Transfer[] $transfers
 * @property-read int|null $transfers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VacationRequest[] $vacation_requests
 * @property-read int|null $vacation_requests_count
 * @property-read \Bavix\Wallet\Models\Wallet $wallet
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bavix\Wallet\Models\Wallet[] $wallets
 * @property-read int|null $wallets_count
 * @method static \Alexmg86\LaravelSubQuery\Collection\LaravelSubQueryCollection|static[] all($columns = ['*'])
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User castColumn($column, $type = null)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User eagerLoadRelationsOne(array $models, string $type)
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User forceIndex($column)
 * @method static \Alexmg86\LaravelSubQuery\Collection\LaravelSubQueryCollection|static[] get($columns = ['*'])
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User like($column, $value, $condition = false)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User likeLeft($column, $value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User likeRight($column, $value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User newModelQuery()
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User orderByRelation($relations, $orderType = 'desc', $type = 'max')
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User permission($permissions)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User query()
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User role($roles, $guard = null)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User setWithAvg($withAvg)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User setWithMax($withMax)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User setWithMin($withMin)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User setWithSum($withSum)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereApplicationId($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereCreatedAt($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereCurrentDay($column = 'created_at')
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereCurrentMonth($column = 'created_at')
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereCurrentYear($column = 'created_at')
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereDateOfBirth($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereDeletedAt($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereDiscord($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereDriverLevel($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereEmail($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereEmailVerifiedAt($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereId($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereLastIpAddress($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User wherePassword($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereProfileBannerPath($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereProfilePicturePath($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereRememberToken($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereSlug($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereSteamId($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereTruckersmpId($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereUpdatedAt($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereUsername($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereWelcomeToken($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User whereWelcomeValidUntil($value)
 * @method static \Alexmg86\LaravelSubQuery\LaravelSubQuery|User withMath($columns, $operator = '+', $name = null)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements Wallet
{
    use HasFactory;
    use Notifiable;
    use HasRolesTrait;
    use SoftDeletes;
    use HasWallet;
    use HasWallets;
    use HasSettingsTable;
    use LaravelSubQueryTrait;
    use HasApiTokens;
    use RevisionableTrait;
    use Impersonate;
    use Achiever;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'username',
        'slug',
        'email',
        'steam_id',
        'truckersmp_id',
        'date_of_birth',
        'last_ip_address',
        'password',
        'welcome_valid_until',
        'welcome_token',
        'application_id',
        'discord',
        'profile_picture_path',
        'profile_banner_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'welcome_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'discord' => 'array',
    ];

    public array $defaultSettings = [
        'preferences.distance' => 'kilometres',
        'preferences.currency' => 'euro',
        'preferences.weight' => 'tonnes',
    ];

    protected array $dontKeepRevisionOf = ['password', 'remember_token'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get all of the vacation requests for the user.
     *
     * @returns HasMany
     */
    public function vacation_requests(): HasMany
    {
        return $this->hasMany(VacationRequest::class);
    }

    /**
     * Get the driver application of the user.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function revisionHistoryWithUser(): MorphMany
    {
        return $this->morphMany(Revision::class, 'revisionable')->with('user');
    }

    /**
     * Get the user's profile picture.
     *
     * @return string
     */
    public function getProfilePictureAttribute(): ?string
    {
        try {
            return Storage::disk('scaleway')->url($this->profile_picture_path);
        } catch (\Exception $e) {
            return "https://eu.ui-avatars.com/api/?background=DC2F02&color=FFFFFF&format=svg&name=$this->username";
        }
    }

    /**
     * Get the user's profile banner.
     *
     * @return string
     */
    public function getProfileBannerAttribute(): ?string
    {
        try {
            return Storage::disk('scaleway')->url($this->profile_banner_path);
        } catch (\Exception $e) {
            return "https://phoenix-base.s3.nl-ams.scw.cloud/images/227300_20210216162827_1.png";
        }
    }

    /**
     * Get all of the jobs of the user.
     *
     * @returns HasMany
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function getDefaultWalletBalanceAttribute(): int
    {
        $balance = $this->getWallet('default')->balance ?? 0;

        // Convert to USD if required
        if (Auth::user()->settings()->get('preferences.currency') === 'dollar') {
            $balance *= 1.21;
        }

        return $balance;
    }

    public function getPreferredCurrencySymbolAttribute(): ?string
    {
        return strip_tags('&' . $this->settings()->get('preferences.currency') . ';');
    }

    public function getQualifiedPreferredDistanceAttribute(): ?string
    {
        return $this->settings()->get('preferences.distance');
    }

    public function getPreferredDistanceAbbreviationAttribute(): string
    {
        $preference = $this->settings()->get('preferences.distance');

        if ($preference === 'kilometres') {
            return 'km';
        }

        if ($preference === 'miles') {
            return 'mi';
        }

        return '';
    }

    public function getSteamPlayerSummaryAttribute(): ?Player
    {
        // Cached for 15 minutes
        return Cache::remember($this->id . '_steam', 900, function () {
            $steamClient = new SteamClient();

            return $steamClient->user($this->steam_id ?? 0)->GetPlayerSummaries()[0] ?? null;
        });
    }

    public function getTruckersMpDataAttribute(): array
    {
        // Cached for 15 minutes
        return Cache::remember($this->id . '_truckersmp', 900, function () {
            $client = new Client();

            $response = $client->get('https://api.truckersmp.com/v2/player/' . $this->truckersmp_id)->getBody();
            $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

            if ($response['error']) {
                return [];
            }

            return $response['response'];
        });
    }

    public function getDriverLevelAttribute(): int|float
    {
        $total_distance = $this->jobs()->sum('distance');

        if ($total_distance <= 10000) {
            $level = $total_distance * 0.001;
        } else {
            $level = $total_distance / 2000 + 5;
        }

        return floor($level);
    }

    public function getNextDriverLevelDistanceAttribute(): int|float
    {
        $level = $this->getDriverLevelAttribute();

        if ($level <= 10) {
            $current_level_distance = $level / 0.001;

            return $current_level_distance + 1000;
        }

        $current_level_distance = -10000 + 2000 * $level;

        return $current_level_distance + 2000;
    }

    public function getRequiredDistanceUntilNextLevelAttribute(): int|float
    {
        $total_distance = $this->jobs()->sum('distance');
        $level = $this->getDriverLevelAttribute();

        if ($level <= 10) {
            $current_level_distance = $level / 0.001;

            $next_level_distance = $current_level_distance + 1000;
        } else {
            $current_level_distance = -10000 + 2000 * $level;

            $next_level_distance = $current_level_distance + 2000;
        }

        return floor($next_level_distance - $total_distance);
    }

    public function getPercentageUntilDriverLevelUpAttribute(): int|float
    {
        $total_distance = $this->jobs()->sum('distance');
        $level = $this->getDriverLevelAttribute();

        if ($level <= 10) {
            return floor(($total_distance / 1000 - $level) * 100);
        }

        return floor(($total_distance / 2000 + 5 - $level) * 100);
    }

    public function canImpersonate(): bool
    {
        return $this->can('impersonate users');
    }

    public function canBeImpersonated(): bool
    {
        return Auth::user()->roleLevel() > $this->roleLevel();
    }
}
