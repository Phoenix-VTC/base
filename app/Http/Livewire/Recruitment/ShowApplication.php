<?php

namespace App\Http\Livewire\Recruitment;

use App\Models\Application;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowApplication extends Component
{
    public object $application;
    public string $comment = '';

    protected $rules = [
        'comment' => 'required',
    ];

    public function mount($uuid)
    {
        $this->application = Application::where('uuid', $uuid)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.recruitment.show')->extends('layouts.app');
    }

    public function claim()
    {
        $this->application->claimed_by = Auth::id();
        $this->application->save();
    }

    public function unclaim()
    {
        $this->application->claimed_by = null;
        $this->application->save();
    }

    public function submitComment()
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

    public function deleteComment($uuid)
    {
        $comment = Comment::where('uuid', $uuid)->firstOrFail();

        $comment->delete();
    }

    public function hydrate()
    {
        $this->application = $this->application->fresh();
    }
}
