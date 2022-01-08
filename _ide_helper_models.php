<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string|null $slug
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
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $welcome_valid_until
 * @property string|null $welcome_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\Assada\Achievements\Model\AchievementProgress[] $achievements
 * @property-read int|null $achievements_count
 * @property-read \App\Models\Application|null $application
 * @property-read float|int|string $balance
 * @property-read int $balance_int
 * @property-read int $default_wallet_balance
 * @property-read int $driver_level
 * @property-read int $next_driver_level_distance
 * @property-read int $percentage_until_driver_level_up
 * @property-read string|null $preferred_currency_symbol
 * @property-read string $preferred_distance_abbreviation
 * @property-read string $profile_banner
 * @property-read string $profile_picture
 * @property-read string|null $qualified_preferred_distance
 * @property-read int $required_distance_until_next_level
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
 */
	class User extends \Eloquent implements \Bavix\Wallet\Interfaces\Wallet {}
}

