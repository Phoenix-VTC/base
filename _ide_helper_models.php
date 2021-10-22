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
 * App\Models\Application
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $claimed_by
 * @property string $username
 * @property string $email
 * @property string|null $discord_username
 * @property string $date_of_birth
 * @property string $country
 * @property \Illuminate\Support\Collection $steam_data
 * @property int $truckersmp_id
 * @property \Illuminate\Support\Collection $application_answers
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read int $age
 * @property-read \Illuminate\Support\Collection $ban_history
 * @property-read bool $is_completed
 * @property-read string|null $time_until_completion
 * @property-read \Illuminate\Support\Collection $truckers_m_p_data
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Revision[] $revisionHistoryWithUser
 * @property-read int|null $revision_history_with_user_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ApplicationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApplicationAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereClaimedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereDiscordUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSteamData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereTruckersmpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUuid($value)
 */
	class Application extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cargo
 *
 * @property int $id
 * @property string $name
 * @property string|null $dlc
 * @property string|null $mod
 * @property int|null $weight
 * @property int|null $game_id
 * @property int $world_of_trucks
 * @property bool $approved
 * @property int|null $requested_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $jobs
 * @property-read int|null $jobs_count
 * @property-read \App\Models\User|null $requester
 * @method static \Database\Factories\CargoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereDlc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereMod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereWorldOfTrucks($value)
 */
	class Cargo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property string $real_name
 * @property string $name
 * @property string $country
 * @property string|null $dlc
 * @property string|null $mod
 * @property int|null $game_id
 * @property int|null $x
 * @property int|null $z
 * @property bool $approved
 * @property int|null $requested_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $destinationJobs
 * @property-read int|null $destination_jobs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $pickupJobs
 * @property-read int|null $pickup_jobs_count
 * @property-read \App\Models\User|null $requester
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDlc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereMod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereZ($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Comment
 *
 * @property int $id
 * @property string $uuid
 * @property int $author
 * @property string $commentable_type
 * @property int $commentable_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\CommentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUuid($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property string|null $category
 * @property string|null $specialization
 * @property string|null $dlc
 * @property string|null $mod
 * @property int $game_id
 * @property bool $approved
 * @property int|null $requested_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $destinationJobs
 * @property-read int|null $destination_jobs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $pickupJobs
 * @property-read int|null $pickup_jobs_count
 * @property-read \App\Models\User|null $requester
 * @method static \Database\Factories\CompanyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDlc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereMod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSpecialization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Download extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $name
 * @property int $hosted_by
 * @property string $featured_image_url
 * @property string|null $map_image_url
 * @property string $description
 * @property string|null $server
 * @property string|null $required_dlcs
 * @property string|null $departure_location
 * @property string|null $arrival_location
 * @property \Illuminate\Support\Carbon $start_date
 * @property int|null $distance
 * @property int $points
 * @property int|null $game_id
 * @property int|null $tmp_event_id
 * @property bool $published
 * @property bool $featured
 * @property bool $external_event
 * @property bool $public_event
 * @property int|null $created_by
 * @property bool $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventAttendee[] $attendees
 * @property-read int|null $attendees_count
 * @property-read \App\Models\User|null $creator
 * @property-read string $distance_metric
 * @property-read bool $is_high_rewarding
 * @property-read bool $is_past
 * @property-read string $slug
 * @property-read string $t_m_p_description
 * @property-read mixed $truckers_m_p_event_data
 * @property-read mixed $truckers_m_p_event_v_t_c_data
 * @property-read \App\Models\User $host
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Revision[] $revisionHistoryWithUser
 * @property-read int|null $revision_history_with_user_count
 * @method static \Database\Factories\EventFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Query\Builder|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereArrivalLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDepartureLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereExternalEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereFeaturedImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereHostedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereMapImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePublicEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRequiredDlcs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereServer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTmpEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Event withoutTrashed()
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventAttendee
 *
 * @property int $id
 * @property int $user_id
 * @property int $event_id
 * @property \App\Enums\Attending $attending
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event $event
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\EventAttendeeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereAttending($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereUserId($value)
 */
	class EventAttendee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Game
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 */
	class Game extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Job
 *
 * @property int $id
 * @property int $user_id
 * @property int $game_id
 * @property int $pickup_city_id
 * @property int $destination_city_id
 * @property int $pickup_company_id
 * @property int $destination_company_id
 * @property int $cargo_id
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $finished_at
 * @property int $distance
 * @property int $load_damage
 * @property int $estimated_income
 * @property int $total_income
 * @property string|null $comments
 * @property \App\Enums\JobStatus $status
 * @property bool $tracker_job
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cargo $cargo
 * @property-read \App\Models\City $destinationCity
 * @property-read \App\Models\Company $destinationCompany
 * @property-read bool $can_edit
 * @property-read bool $has_pending_game_data
 * @property-read int $price_per_distance
 * @property-read \App\Models\City $pickupCity
 * @property-read \App\Models\Company $pickupCompany
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Revision[] $revisionHistoryWithUser
 * @property-read int|null $revision_history_with_user_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\JobFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job query()
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCargoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereDestinationCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereDestinationCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereEstimatedIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereLoadDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job wherePickupCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job wherePickupCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereTotalIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereTrackerJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUserId($value)
 */
	class Job extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Revision extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Screenshot extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
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
 * @property-read \App\Models\Application|null $application
 * @property-read int|float|string $balance
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

namespace App\Models{
/**
 * App\Models\VacationRequest
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $handled_by
 * @property string $reason
 * @property int $leaving
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $duration
 * @property-read bool $is_active
 * @property-read bool $is_expired
 * @property-read bool $is_upcoming
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Revision[] $revisionHistoryWithUser
 * @property-read int|null $revision_history_with_user_count
 * @property-read \App\Models\User|null $staff
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest newQuery()
 * @method static \Illuminate\Database\Query\Builder|VacationRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest whereHandledBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest whereLeaving($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacationRequest whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|VacationRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|VacationRequest withoutTrashed()
 */
	class VacationRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Vote
 *
 * @property int $id
 * @property int $user_id
 * @property string $votable_type
 * @property int $votable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $votable
 * @method static \Illuminate\Database\Eloquent\Builder|Vote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereVotableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereVotableType($value)
 */
	class Vote extends \Eloquent {}
}

