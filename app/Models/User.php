<?php

namespace App\Models;

use App\Notifications\DriverApplication\WelcomeNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use ReceivesWelcomeNotification;

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
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
     * Send the welcome notification
     *
     * @param User $user
     * @param Carbon $validUntil
     */
    public function sendWelcomeNotification(User $user, Carbon $validUntil): void
    {
        $this->notify(new WelcomeNotification($user, $validUntil));
    }
}
