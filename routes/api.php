<?php

use App\Http\Controllers\API\DiscordBotController;
use App\Http\Controllers\API\Select2\GameDataController;
use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', function ($api) {
    $api->group(['prefix' => 'game-data/{game}', 'as' => 'game-data-'], function ($api) {
        $api->get('cities', [GameDataController::class, 'indexCities'])->name('cities');
        $api->get('companies', [GameDataController::class, 'indexCompanies'])->name('companies');
        $api->get('cargos', [GameDataController::class, 'indexCargos'])->name('cargos');
    });
});
