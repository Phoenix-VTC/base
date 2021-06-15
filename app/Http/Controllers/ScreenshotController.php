<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use App\Models\Vote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ScreenshotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggleVote(Screenshot $screenshot): RedirectResponse
    {
        if ($vote = $screenshot->votes()->where('user_id', Auth::id())->first()) {
            $vote->delete();

            session()->flash('alert', ['type' => 'success', 'message' => "Your vote for <b>$screenshot->title</b> has been removed!"]);
        } else {
            $vote = new Vote([
                'user_id' => Auth::id(),
            ]);

            $screenshot->votes()->save($vote);

            session()->flash('alert', ['type' => 'success', 'message' => "Successfully voted for <b>$screenshot->title</b>!"]);
        }

        return back();
    }
}
