<?php

namespace App\Http\Livewire\ScreenshotHub;

use App\Models\Screenshot;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowShowPage extends Component
{
    use AuthorizesRequests;

    public Screenshot $screenshot;

    public function mount(): void
    {
        $this->authorize('view', $this->screenshot);

        $this->screenshot::has('user')->findOrFail($this->screenshot->id);
    }

    public function render()
    {
        return view('livewire.screenshot-hub.show-page')->extends('layouts.app');
    }

    public function delete()
    {
        $this->authorize('delete', $this->screenshot);

        $this->screenshot->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'Screenshot successfully deleted!']);

        return redirect()->route('screenshot-hub.index');
    }
}
