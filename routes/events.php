<?php

use App\Http\Livewire\Events\Home;
use App\Http\Livewire\Events\ShowEvent;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)
    ->name('home');

Route::get('{id}-{slug}', ShowEvent::class)
    ->name('show');

Route::get('login', function () {
    return redirect()->route('events.home');
})->middleware('auth')->name('login');
