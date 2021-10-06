<?php

namespace App\Providers;

use App\Events\BlocklistEntryDeleted;
use App\Events\BlocklistEntryRestored;
use App\Events\BlocklistEntryUpdated;
use App\Events\EmailChanged;
use App\Events\NewBlocklistEntry;
use App\Events\PasswordChanged;
use App\Events\UserInBlocklistTriedToApply;
use App\Listeners\SendAchievementUnlockedNotification;
use App\Listeners\SendDeletedBlocklistEntryNotification;
use App\Listeners\SendEmailChangedNotification;
use App\Listeners\SendFailedJobDiscordNotification;
use App\Listeners\SendNewBlocklistEntryNotification;
use App\Listeners\SendPasswordChangedNotification;
use App\Listeners\SendPasswordResetNotification;
use App\Listeners\SendRestoredBlocklistEntryNotification;
use App\Listeners\SendUpdatedBlocklistEntryNotification;
use App\Listeners\SendUserInBlocklistTriedToApplyNotification;
use App\Models\Download as DownloadModel;
use App\Models\Screenshot as ScreenshotModel;
use App\Observers\DownloadObserver;
use App\Models\Job as JobModel;
use App\Observers\JobObserver;
use App\Observers\ScreenshotObserver;
use Assada\Achievements\Event\Unlocked as UnlockedAchievement;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Laravel\Horizon\Events\JobFailed;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SocialiteWasCalled::class => [
            'SocialiteProviders\\Discord\\DiscordExtendSocialite@handle',
        ],
        UnlockedAchievement::class => [
            SendAchievementUnlockedNotification::class,
        ],
        PasswordReset::class => [
            SendPasswordResetNotification::class,
        ],
        PasswordChanged::class => [
            SendPasswordChangedNotification::class,
        ],
        EmailChanged::class => [
            SendEmailChangedNotification::class,
        ],
        JobFailed::class => [
            SendFailedJobDiscordNotification::class,
        ],
        UserInBlocklistTriedToApply::class => [
            SendUserInBlocklistTriedToApplyNotification::class,
        ],
        NewBlocklistEntry::class => [
            SendNewBlocklistEntryNotification::class,
        ],
        BlocklistEntryUpdated::class => [
            SendUpdatedBlocklistEntryNotification::class,
        ],
        BlocklistEntryDeleted::class => [
            SendDeletedBlocklistEntryNotification::class,
        ],
        BlocklistEntryRestored::class => [
            SendRestoredBlocklistEntryNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        JobModel::observe(JobObserver::class);
        DownloadModel::observe(DownloadObserver::class);
        ScreenshotModel::observe(ScreenshotObserver::class);
    }
}
