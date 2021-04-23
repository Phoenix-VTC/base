<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWallets;
use Glorand\Model\Settings\Traits\HasSettingsTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

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
}
