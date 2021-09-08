<?php

use App\Http\Controllers\API\DiscordBotController;
use App\Http\Controllers\API\Select2\GameDataController;
use App\Http\Controllers\API\Select2\UserController;
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

Route::prefix('discord-bot')->middleware('auth.discordBot')->group(function ($group) {
    Route::get('users/{id}', [DiscordBotController::class, 'findUserByDiscordId']);
});

Route::get('users', [UserController::class, 'index'])->name('users');
