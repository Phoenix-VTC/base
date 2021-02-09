<?php

use App\Http\Livewire\Auth\ShowWelcomeForm;
use \App\Http\Livewire\Recruitment\ShowApplication;
use \App\Http\Livewire\Recruitment\ShowIndex as RecruitmentShowIndex;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
use App\Http\Livewire\ShowDashboard;
use App\Http\Livewire\VacationRequests\ShowCreate as VacationRequestsShowCreate;
use App\Http\Livewire\VacationRequests\ShowIndex as VacationRequestsShowIndex;
use App\Http\Livewire\VacationRequestsManagement\ShowIndex as VacationRequestsManagementShowIndex;
use App\Http\Livewire\UserManagement\ShowIndex as UserManagementShowIndex;
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
});

Route::prefix('vacation-requests')->name('vacation-requests.')->middleware(['auth'])->group(function () {
    Route::get('/', VacationRequestsShowIndex::class)->name('index');
    Route::get('create', VacationRequestsShowCreate::class)->name('create');
});

Route::prefix('vacation-requests/manage')->name('vacation-requests.manage.')->middleware(['auth', 'can:manage vacation requests'])->group(function () {
    Route::get('index', VacationRequestsManagementShowIndex::class)->name('index');
});

Route::get('welcome/{token}', ShowWelcomeForm::class)->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');

    Route::get('/dashboard', function () {
        return redirect('https://apply.phoenixvtc.com');
    })->name('register');
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
