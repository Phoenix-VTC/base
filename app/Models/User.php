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
