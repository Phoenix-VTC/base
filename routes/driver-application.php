<?php

use App\Http\Controllers\DriverApplication\AuthController;
use App\Http\Livewire\DriverApplication\Auth as DriverAuth;
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

Route::get('/', DriverAuth::class)->name('authenticate');

Route::prefix('auth/steam')->name('auth.')->group(function () {
    Route::get('/', [AuthController::class, 'redirectToSteam'])->name('steam');
    Route::name('steam.')->group(function () {
        Route::get('handle', [AuthController::class, 'handle'])->name('handle');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
