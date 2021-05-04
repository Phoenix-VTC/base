<?php

use App\Http\Controllers\EventManagementController;
use App\Http\Livewire\Auth\ShowWelcomeForm;
use App\Http\Livewire\Events\Management\ShowEdit as EventsManagementShowEdit;
use App\Http\Livewire\Events\Management\ShowCreate as EventsManagementShowCreate;
use App\Http\Livewire\Events\Management\ShowIndex as EventsManagementShowIndex;
use App\Http\Livewire\Events\Management\ShowAttendeeManagement as EventsManagementShowAttendeeManagement;
use App\Http\Livewire\GameData\Cargos\ShowIndexPage as CargosShowIndexPage;
use App\Http\Livewire\GameData\Cities\ShowIndexPage as CitiesShowIndexPage;
use App\Http\Livewire\GameData\Companies\ShowIndexPage as CompaniesShowIndexPage;
use App\Http\Livewire\Jobs\ShowPersonalOverviewPage as JobsShowPersonalOverviewPage;
use App\Http\Livewire\Users\ShowJobOverviewPage as UsersShowJobOverviewPage;
use App\Http\Livewire\Jobs\Submit\ShowSelectGamePage as JobsShowSelectGamePage;
use App\Http\Livewire\Jobs\Submit\ShowSubmitPage as JobsShowSubmitPage;
use App\Http\Livewire\Jobs\ShowShowPage as JobsShowShowPage;
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
});

Route::prefix('game-data')->name('game-data.')->middleware(['auth', 'can:manage game data'])->group(function () {
    Route::get('cargos', CargosShowIndexPage::class)->name('cargos');
    Route::get('cities', CitiesShowIndexPage::class)->name('cities');
    Route::get('companies', CompaniesShowIndexPage::class)->name('companies');
});

Route::prefix('jobs')->name('jobs.')->middleware(['auth', 'can:submit jobs'])->group(function () {
    Route::get('personal-overview', JobsShowPersonalOverviewPage::class)->name('personal-overview');
    Route::get('choose-game', JobsShowSelectGamePage::class)->name('choose-game');
    Route::get('submit/{game_id}', JobsShowSubmitPage::class)
        ->whereNumber('game_id')
        ->name('submit');
    Route::get('{job}', JobsShowShowPage::class)->name('show');
});

Route::prefix('settings')->name('settings.')->middleware('auth')->group(function () {
    Route::get('preferences', SettingsShowPreferencesPage::class)->name('preferences');
    Route::get('account', SettingsShowAccountPage::class)->middleware('password.confirm')->name('account');
});

Route::get('my-wallet', WalletShowIndexPage::class)->middleware('auth')->name('my-wallet');

Route::get('profile', function () {
    return redirect()->route('users.profile', Auth::user());
})->middleware('auth')->name('profile');

Route::prefix('users')->name('users.')->middleware('auth')->group(function () {
    Route::get('{id}', ShowProfilePage::class)->name('profile');

    Route::get('{user}/jobs', UsersShowJobOverviewPage::class)->name('jobs-overview');

    Route::get('{id}/edit', UserManagementShowEditPage::class)->middleware('can:manage users')->name('edit');
});

Route::get('welcome/{token}', ShowWelcomeForm::class)->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');
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
