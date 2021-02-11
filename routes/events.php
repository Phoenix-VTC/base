<?php

use App\Http\Livewire\Events\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)
    ->name('home');

Route::get('login', function () {
    return redirect()->route('events.home');
})->middleware('auth')->name('login');
