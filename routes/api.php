<?php

use App\Http\Controllers\API\CmsController;
use App\Http\Controllers\API\DiscordBotController;
use App\Http\Controllers\API\Select2\GameDataController;
use App\Http\Controllers\API\Select2\UserController;
use App\Http\Controllers\API\Tracker\EventController;
use App\Http\Controllers\API\Tracker\IncomingDataController;
use App\Http\Controllers\API\Tracker\JobController;
use App\Http\Controllers\API\OnlineUserController;
use App\Http\Controllers\API\Tracker\MultiplayerController;
use Illuminate\Support\Facades\Route;

Route::prefix('game-data/{game}')->name('game-data.')->group(function ($group) {
    Route::get('cities', [GameDataController::class, 'indexCities'])->name('cities');
    Route::get('companies', [GameDataController::class, 'indexCompanies'])->name('companies');
    Route::get('cargos', [GameDataController::class, 'indexCargos'])->name('cargos');

    // Validate game param for each route
    foreach ($group->getRoutes() as $route) {
        $route->whereNumber('game');
    }
});

Route::prefix('discord-bot')->middleware('auth.discordBot')->group(function () {
    Route::get('users/{id}', [DiscordBotController::class, 'findUserByDiscordId']);
});

Route::get('users', [UserController::class, 'index'])->name('users');

Route::prefix('tracker')->middleware(['auth:sanctum', 'sanctum.canSubmitJobs'])->group(function () {
    Route::post('/', [IncomingDataController::class, 'handleRequest'])->middleware('userActivity.tracker');

    Route::resource('jobs', JobController::class)->only([
        'index',
    ]);

    Route::get('online-users', [OnlineUserController::class, 'onlineTrackerUsers']);

    Route::get('pending-jobs-count', function (\Illuminate\Http\Request $request) {
        return Cache::remember("pending-jobs-count-{$request->user()->id}", 900, function () use ($request) {
            return $request->user()
                ->jobs()
                ->whereIn('status', [0, 1])
                ->count();
        });
    });

    Route::get('events/next', [EventController::class, 'showNext']);
    Route::apiResource('events', EventController::class)->only([
        'index',
        'show',
    ]);

    Route::get('resolve-truckersmp-player-data', [MultiplayerController::class, 'resolveTruckersmpPlayerData']);
    Route::get('resolve-location', [MultiplayerController::class, 'resolveNearestCityFromCoordinates']);
});

Route::middleware('auth:sanctum')->get('/user', function (\Illuminate\Http\Request $request) {
    $user = $request->user();

    return [
        'id' => $user->id,
        'username' => $user->username,
        'truckersmp_id' => $user->truckersmp_id,
        'wallet_balance' => $user->getWallet('default')->balance ?? 0,
        'event_xp' => $user->getWallet('event-xp')->balance ?? 0,
        'profile_picture' => $user->profile_picture,
        'profile_link' => route('users.profile', $user)
    ];
});

Route::prefix('cms')->group(function () {
    Route::get('statistics', [CmsController::class, 'statistics']);
});

