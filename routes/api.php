<?php

use App\Http\Controllers\API\Select2\GameDataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ->middleware(['auth', 'can:submit jobs'])
Route::prefix('game-data/{game}')->name('game-data.')->group(function ($group) {
    Route::get('cities', [GameDataController::class, 'indexCities'])->name('cities');

    Route::get('companies', [GameDataController::class, 'indexCompanies'])->name('companies');

    Route::get('cargos', [GameDataController::class, 'indexCargos'])->name('cargos');

    // Validate game param for each route
    foreach ($group->getRoutes() as $route) {
        $route->whereNumber('game');
    }
});
