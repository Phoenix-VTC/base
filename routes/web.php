<?php

use App\Http\Controllers\EventManagementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ScreenshotController;
use App\Http\Controllers\UserManagement\UserController as UserManagementUserController;
use App\Http\Livewire\Auth\ShowWelcomeForm;
use App\Http\Livewire\Downloads\ShowIndexPage as DownloadsShowIndexPage;
use App\Http\Livewire\DownloadsManagement\ShowEditPage as DownloadsManagementShowEditPage;
use App\Http\Livewire\DownloadsManagement\ShowCreatePage as DownloadsManagementShowCreatePage;
use App\Http\Livewire\DownloadsManagement\ShowIndexPage as DownloadsManagementShowIndexPage;
use App\Http\Livewire\DownloadsManagement\ShowRevisionsPage as DownloadsManagementShowRevisionsPage;
use App\Http\Livewire\Events\Management\ShowEdit as EventsManagementShowEdit;
use App\Http\Livewire\Events\Management\ShowCreate as EventsManagementShowCreate;
use App\Http\Livewire\Events\Management\ShowIndex as EventsManagementShowIndex;
use App\Http\Livewire\Events\Management\ShowAttendeeManagement as EventsManagementShowAttendeeManagement;
use App\Http\Livewire\Events\Management\ShowRevisionsPage as EventsManagementShowRevisionsPage;
use App\Http\Livewire\GameData\Cargos\ShowIndexPage as CargosShowIndexPage;
use App\Http\Livewire\GameData\Cargos\ShowEditPage as CargosShowEditPage;
use App\Http\Livewire\GameData\Cities\ShowIndexPage as CitiesShowIndexPage;
use App\Http\Livewire\GameData\Cities\ShowEditPage as CitiesShowEditPage;
use App\Http\Livewire\GameData\Companies\ShowIndexPage as CompaniesShowIndexPage;
use App\Http\Livewire\GameData\Companies\ShowEditPage as CompaniesShowEditPage;
use App\Http\Livewire\ScreenshotHub\ShowShowPage as ScreenshotHubShowShowPage;
use App\Http\Livewire\ScreenshotHub\ShowCreatePage as ScreenshotHubShowCreatePage;
use App\Http\Livewire\ScreenshotHub\ShowIndexPage as ScreenshotHubShowIndexPage;
use App\Http\Livewire\ShowLeaderboardPage;
use App\Http\Livewire\Jobs\ShowPersonalOverviewPage as JobsShowPersonalOverviewPage;
use App\Http\Livewire\ShowNotificationsPage;
use App\Http\Livewire\UserManagement\DriverInactivity\ShowIndexPage as DriverInactivityShowIndexPage;
use App\Http\Livewire\Users\ShowJobOverviewPage as UsersShowJobOverviewPage;
use App\Http\Livewire\Jobs\Submit\ShowSelectGamePage as JobsShowSelectGamePage;
use App\Http\Livewire\Jobs\Submit\ShowSubmitPage as JobsShowSubmitPage;
use App\Http\Livewire\Jobs\ShowShowPage as JobsShowShowPage;
use App\Http\Livewire\Jobs\ShowEditPage as JobsShowEditPage;
use \App\Http\Livewire\Recruitment\ShowApplication;
use \App\Http\Livewire\Recruitment\ShowIndex as RecruitmentShowIndex;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Verify;
use App\Http\Livewire\Settings\ShowPreferencesPage as SettingsShowPreferencesPage;
use App\Http\Livewire\Settings\ShowAccountPage as SettingsShowAccountPage;
use App\Http\Livewire\Settings\ShowSecurityPage as SettingsShowSecurityPage;
use App\Http\Livewire\Settings\ShowSocialsPage as SettingsShowSocialsPage;
use App\Http\Livewire\ShowDashboard;
use App\Http\Livewire\UserManagement\ShowEditPage as UserManagementShowEditPage;
use App\Http\Livewire\Users\ShowProfilePage;
use App\Http\Livewire\VacationRequests\ShowCreate as VacationRequestsShowCreate;
use App\Http\Livewire\VacationRequests\ShowIndex as VacationRequestsShowIndex;
use App\Http\Livewire\VacationRequestsManagement\ShowIndex as VacationRequestsManagementShowIndex;
use App\Http\Livewire\UserManagement\ShowIndex as UserManagementShowIndex;
use App\Http\Livewire\UserManagement\Roles\ShowIndexPage as UserManagementRolesShowIndex;
use App\Http\Livewire\UserManagement\Permissions\ShowIndexPage as UserManagementPermissionsShowIndex;
use App\Http\Livewire\Wallet\ShowIndexPage as WalletShowIndexPage;
use App\Http\Controllers\Auth\SteamController as SteamAuthController;
use App\Http\Controllers\Auth\DiscordController as DiscordAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ShowDashboard::class)
    ->middleware('auth')
    ->name('dashboard');

Route::prefix('recruitment')->name('recruitment.')->middleware(['auth', 'can:handle driver applications'])->group(function () {
    Route::get('index', RecruitmentShowIndex::class)->name('index');
    Route::get('application/{uuid}', ShowApplication::class)->name('show');
});

Route::prefix('user-management')->name('user-management.')->middleware(['auth', 'can:manage users'])->group(function () {
    Route::get('index', UserManagementShowIndex::class)->name('index');
    Route::get('roles/index', UserManagementRolesShowIndex::class)->name('roles.index');
    Route::get('permissions/index', UserManagementPermissionsShowIndex::class)->name('permissions.index');
    Route::get('driver-inactivity/index', DriverInactivityShowIndexPage::class)->middleware('can:manage driver inactivity')->name('driver-inactivity.index');
});

Route::prefix('vacation-requests')->name('vacation-requests.')->middleware(['auth'])->group(function () {
    Route::get('/', VacationRequestsShowIndex::class)->name('index');
    Route::get('create', VacationRequestsShowCreate::class)->name('create');
});

Route::prefix('vacation-requests/manage')->name('vacation-requests.manage.')->middleware(['auth', 'can:manage vacation requests'])->group(function () {
    Route::get('index', VacationRequestsManagementShowIndex::class)->name('index');
});

Route::prefix('event-management')->name('event-management.')->middleware(['auth', 'can:manage events'])->group(function () {
    Route::get('/', EventsManagementShowIndex::class)->name('index');
    Route::get('create', EventsManagementShowCreate::class)->name('create');
    Route::get('{event}/edit', EventsManagementShowEdit::class)->name('edit');
    Route::post('{event}/delete', [EventManagementController::class, 'delete'])->name('delete');
    Route::get('{id}/manage-attendees', EventsManagementShowAttendeeManagement::class)->name('attendee-management');
    Route::post('{event}/reward-event-xp', [EventManagementController::class, 'rewardEventXP'])->name('reward-event-xp');
    Route::get('{event}/revisions', EventsManagementShowRevisionsPage::class)->name('revisions');
});

Route::prefix('game-data')->name('game-data.')->middleware(['auth', 'can:manage game data'])->group(function () {
    Route::get('cargos', CargosShowIndexPage::class)->name('cargos');
    Route::get('cargos/{cargo}/edit', CargosShowEditPage::class)->name('cargos.edit');

    Route::get('cities', CitiesShowIndexPage::class)->name('cities');
    Route::get('cities/{city}/edit', CitiesShowEditPage::class)->name('cities.edit');

    Route::get('companies', CompaniesShowIndexPage::class)->name('companies');
    Route::get('companies/{company}/edit', CompaniesShowEditPage::class)->name('companies.edit');
});

Route::prefix('jobs')->name('jobs.')->middleware(['auth', 'can:submit jobs'])->group(function () {
    Route::get('personal-overview', JobsShowPersonalOverviewPage::class)->name('personal-overview');
    Route::get('choose-game', JobsShowSelectGamePage::class)->name('choose-game');
    Route::get('submit/{game_id}', JobsShowSubmitPage::class)
        ->whereNumber('game_id')
        ->name('submit');

    Route::prefix('{job}')->group(function () {
        Route::get('/', JobsShowShowPage::class)->name('show');
        Route::get('edit', JobsShowEditPage::class)->name('edit');
    });
});

Route::get('leaderboard', ShowLeaderboardPage::class)->middleware('auth')->name('leaderboard');

Route::prefix('settings')->name('settings.')->middleware('auth')->group(function () {
    Route::get('preferences', SettingsShowPreferencesPage::class)->name('preferences');
    Route::get('account', SettingsShowAccountPage::class)->middleware(['impersonate.protect', 'password.confirm'])->name('account');
    Route::get('security', SettingsShowSecurityPage::class)->middleware(['impersonate.protect', 'password.confirm'])->name('security');
    Route::get('socials', SettingsShowSocialsPage::class)->middleware(['impersonate.protect', 'password.confirm'])->name('socials');
});

Route::get('my-wallet', WalletShowIndexPage::class)->middleware('auth')->name('my-wallet');

Route::get('profile', function () {
    return redirect()->route('users.profile', Auth::user());
})->middleware('auth')->name('profile');

Route::prefix('users')->name('users.')->middleware('auth')->group(function () {
    Route::get('{id}', ShowProfilePage::class)->name('profile');

    Route::get('{user}/jobs', UsersShowJobOverviewPage::class)->name('jobs-overview');

    Route::prefix('{id}')->middleware('can:manage users')->group(function () {
        Route::get('edit', UserManagementShowEditPage::class)->name('edit');

        Route::get('remove-profile-picture', [UserManagementUserController::class, 'removeProfilePicture'])->name('removeProfilePicture');
        Route::get('remove-profile-banner', [UserManagementUserController::class, 'removeProfileBanner'])->name('removeProfileBanner');
    });
});

Route::prefix('downloads')->name('downloads.')->middleware('auth')->group(function () {
    Route::get('index', DownloadsShowIndexPage::class)->name('index');

    Route::prefix('management')->name('management.')->middleware(['auth', 'can:manage downloads'])->group(function () {
        Route::get('index', DownloadsManagementShowIndexPage::class)->name('index');
        Route::get('create', DownloadsManagementShowCreatePage::class)->name('create');
        Route::get('{download}/edit', DownloadsManagementShowEditPage::class)->name('edit');
        Route::get('{download}/revisions', DownloadsManagementShowRevisionsPage::class)->name('revisions');
    });
});

Route::prefix('screenshot-hub')->name('screenshot-hub.')->middleware('auth')->group(function () {
    Route::get('/', ScreenshotHubShowIndexPage::class)->name('index');
    Route::get('create', ScreenshotHubShowCreatePage::class)->name('create');
    Route::prefix('{screenshot}')->group(function () {
        Route::get('/', ScreenshotHubShowShowPage::class)->name('show');
        Route::get('toggle-vote', [ScreenshotController::class, 'toggleVote'])->name('toggleVote');
    });
//    Route::get('{screenshot}/edit', ScreenshotHubShowIndexPage::class)->name('edit');
});

Route::prefix('notifications')->name('notifications.')->middleware('auth')->group(function () {
    Route::get('/', ShowNotificationsPage::class)->name('index');
    Route::post('{notification}/markAsRead', [NotificationController::class, 'markAsRead'])->name('markAsRead');
    Route::get('markAllAsRead', [NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
});

Route::get('welcome/{token}', ShowWelcomeForm::class)->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');

    // Steam Auth
    Route::prefix('auth/steam')->name('auth.steam.')->group(function () {
        Route::post('/', [SteamAuthController::class, 'redirectToSteam'])->name('redirectToSteam');
        Route::get('handle', [SteamAuthController::class, 'handle'])->name('handle');
    });
});

// Discord Auth
Route::prefix('auth/discord')->name('auth.discord.')->group(function () {
    Route::post('/', [DiscordAuthController::class, 'redirectToDiscord'])->name('redirectToDiscord');
    Route::get('handle', [DiscordAuthController::class, 'handle'])->name('handle');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');
});

Route::impersonate();
