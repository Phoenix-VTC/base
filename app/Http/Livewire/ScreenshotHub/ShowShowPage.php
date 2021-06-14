<?php

namespace App\Http\Livewire\ScreenshotHub;

use App\Models\Screenshot;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowShowPage extends Component
{
    public Screenshot $screenshot;

    public function render()
    {
        return view('livewire.screenshot-hub.show-page')->extends('layouts.app');
    }

    public function delete()
    {
        if (Auth::id() !== $this->screenshot->user_id && Auth::user()->cannot('manage users')) {
            abort(403, 'You don\'t have permission to delete this screenshot.');
        }

        $this->screenshot->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'Screenshot successfully deleted!']);

        return redirect()->route('screenshot-hub.index');
    }
}
