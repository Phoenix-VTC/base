<?php

namespace App\Http\Livewire\Recruitment;

use App\Models\Application;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

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
        $this->application->status = 'accepted';
        $this->application->save();

        // Handle acceptation email
    }

    public function deny(): void
    {
        $this->application->status = 'denied';
        $this->application->save();

        // Handle denied email
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
