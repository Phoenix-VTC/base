<?php

use App\Http\Livewire\Events\Home;
use App\Http\Livewire\Events\ShowEvent;
use App\Http\Livewire\Events\ShowLeaderboard;
use App\Http\Livewire\Events\ShowOverview;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)
    ->name('home');

Route::get('{id}-{slug}', ShowEvent::class)
    ->name('show');

Route::get('/overview', ShowOverview::class)
    ->name('overview');

Route::get('/leaderboard', ShowLeaderboard::class)
    ->name('leaderboard');

Route::get('login', function () {
    return redirect()->route('events.home');
})->middleware('auth')->name('login');
