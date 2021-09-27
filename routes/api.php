<?php

use App\Http\Controllers\API\DiscordBotController;
use App\Http\Controllers\API\Select2\GameDataController;
use App\Http\Controllers\API\Tracker\IncomingDataController;
use App\Http\Controllers\API\Tracker\JobController;
use Illuminate\Support\Facades\Route;

//$api = app(Router::class);
//
//$api->version('v1', function ($api) {
//    $api->group(['prefix' => 'game-data/{game}', 'as' => 'game-data-'], function ($api) {
//        $api->get('cities', [GameDataController::class, 'indexCities'])->name('cities');
//        $api->get('companies', [GameDataController::class, 'indexCompanies'])->name('companies');
//        $api->get('cargos', [GameDataController::class, 'indexCargos'])->name('cargos');
//    });
//
//    $api->group(['middleware' => 'auth.discordBot', 'prefix' => 'discord-bot'], function ($api) {
//        $api->get('users/{id}', [DiscordBotController::class, 'findUserByDiscordId']);
//    });
//});

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

Route::prefix('tracker')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [IncomingDataController::class, 'handleRequest']);

    Route::get('user', function () {
        return auth()->user();
    });

    Route::resource('jobs', JobController::class)->only([
        'index',
    ]);
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
        'profile_link' => route('users.profile', $user->id)
    ];
});
