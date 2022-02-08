<?php

namespace App\Http\Livewire\Auth\Passwords;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Component;

class Confirm extends Component
{
    use WithRateLimiting;

    /** @var string */
    public $password = '';

    public function confirm()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            $this->addError('password', "Slow down! Please wait another $exception->secondsUntilAvailable seconds to confirm your password.");

            return;
        }

        $this->validate([
            'password' => ['bail', 'required', 'string', 'current_password'],
        ]);

        session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.passwords.confirm')->extends('layouts.auth');
    }
}
