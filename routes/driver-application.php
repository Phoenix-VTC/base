<?php

use App\Http\Controllers\DriverApplication\AuthController;
use App\Http\Livewire\DriverApplication\Auth as DriverAuth;
use App\Http\Livewire\DriverApplication\ShowBlockedPage;
use App\Http\Livewire\DriverApplication\ShowCompletion;
use App\Http\Livewire\DriverApplication\ShowForm;
use App\Http\Middleware\DriverApplication\NotSteamAuthenticated;
use App\Http\Middleware\DriverApplication\SteamAuthenticated;
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

Route::get('/', DriverAuth::class)->middleware(NotSteamAuthenticated::class)->name('authenticate');

Route::prefix('auth/steam')->name('auth.')->group(function () {
    Route::post('/', [AuthController::class, 'redirectToSteam'])->name('steam');
    Route::name('steam.')->group(function () {
        Route::get('handle', [AuthController::class, 'handle'])->name('handle');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

Route::get('/apply', ShowForm::class)->middleware(SteamAuthenticated::class)->name('apply');

Route::get('application/status/{uuid}', ShowCompletion::class)->name('status');

Route::get('blocked', ShowBlockedPage::class)->middleware(SteamAuthenticated::class)->name('blocked');
