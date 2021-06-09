<?php

namespace App\Models;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWallets;
use Carbon\Carbon;
use Glorand\Model\Settings\Traits\HasSettingsTable;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Syntax\SteamApi\Containers\Player;

class User extends Authenticatable implements Wallet
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use HasRoles;
    use HasWallet;
    use HasWallets;
    use HasSettingsTable;
    use LaravelSubQueryTrait;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
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

    /**
     * Get the user's profile picture.
     *
     * @return string
     */
    public function getProfilePictureAttribute(): string
    {
        return "https://eu.ui-avatars.com/api/?name=$this->username";
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
        if ($this->settings()->get('preferences.currency') === 'dollar') {
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
            return \Steam::user($this->steam_id ?? 0)->GetPlayerSummaries()[0] ?? null;
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
}
