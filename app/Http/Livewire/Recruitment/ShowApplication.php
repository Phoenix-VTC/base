<?php

namespace App\Http\Livewire\Recruitment;

use App\Jobs\Recruitment\ProcessAcceptation;
use App\Mail\DriverApplication\ApplicationDenied;
use App\Models\Application;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Mail;
use Validator;

class ShowApplication extends Component
{
    public object $application;
    public string $comment = '';

    protected array $rules = [
        'comment' => 'required',
    ];

    public function mount($uuid): void
    {
        $this->application = Application::where('uuid', $uuid)->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.recruitment.show')->extends('layouts.app');
    }

    public function claim(): void
    {
        $this->application->claimed_by = Auth::id();
        $this->application->save();
    }

    public function unclaim(): void
    {
        $this->application->claimed_by = null;
        $this->application->save();
    }

    public function submitComment(): void
    {
        $commentData = $this->validate();

        $comment = new Comment([
            'body' => $commentData['comment'],
            'author' => Auth::id(),
        ]);

        $this->application->comments()->save($comment);

        // Empty the comment textarea
        $this->comment = '';
    }

    public function deleteComment($uuid): void
    {
        $comment = Comment::where('uuid', $uuid)->firstOrFail();

        $comment->delete();
    }

    public function clearTMPData(): void
    {
        \Cache::forget($this->application->truckersmp_id . "_truckersmp_data");
        \Cache::forget($this->application->truckersmp_id . "_truckersmp_ban_history");
    }

    public function accept(): void
    {
        Validator::make($this->application->toArray(), [
            'email' => ['email', Rule::unique('users')->whereNull('deleted_at')],
            'truckersmp_id' => [Rule::unique('users')->whereNull('deleted_at')],
            'steam_data.steamID64' => ['required', Rule::unique('users', 'steam_id')->whereNull('deleted_at')],
        ])->validate();

        ProcessAcceptation::dispatch($this->application);

        $this->application->status = 'accepted';
        $this->application->save();

        session()->flash('success', ['message' => 'Application successfully accepted!']);
    }

    public function deny(): void
    {
        $this->application->status = 'denied';
        $this->application->save();

        Mail::to([[
            'email' => $this->application->email,
            'name' => $this->application->username
        ]])->send(new ApplicationDenied($this->application));

        session()->flash('success', ['message' => 'Application successfully denied!']);
    }

    public function setStatus($status): void
    {
        $this->application->status = $status;
        $this->application->save();
    }

    public function blacklist(): void
    {
        $this->application->status = 'denied';
        $this->application->save();

        // Handle blacklist
    }

    public function hydrate(): void
    {
        $this->application = $this->application->fresh();
    }
}
