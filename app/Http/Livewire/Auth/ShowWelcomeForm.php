<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Carbon\Carbon;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Component;

class ShowWelcomeForm extends Component
{
    use WithRateLimiting;

    public string $token;
    public User $user;

    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'password' => ['bail', 'required', 'string', 'min:8', 'confirmed']
    ];

    public function mount($token): void
    {
        $this->user = User::where('welcome_valid_until', '!=', null)->where('welcome_token', $token)->firstOrFail();

        $this->validateToken();
    }

    public function render(): View
    {
        return view('livewire.auth.show-welcome-form')->extends('layouts.auth');
    }

    public function submit()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            $this->addError('password', "Slow down! Please wait another $exception->secondsUntilAvailable seconds to choose your password.");

            return;
        }

        $validatedData = $this->validate();
        $this->validateToken();

        $this->user->password = Hash::make($validatedData['password']);
        $this->user->welcome_valid_until = null;
        $this->user->welcome_token = null;

        $this->user->save();

        Auth::login($this->user);

        return redirect()->intended(route('dashboard'));
    }

    private function validateToken(): void
    {
        if (strlen($this->user->welcome_token) !== 64) {
            abort(403, 'This welcome link has already been used.');
        }

        if (is_null($this->user->welcome_valid_until) || Carbon::parse($this->user->welcome_valid_until)->isPast()) {
            abort(403, 'This welcome link has expired.');
        }
    }
}
