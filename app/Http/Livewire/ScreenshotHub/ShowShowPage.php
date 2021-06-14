<?php

namespace App\Http\Livewire\ScreenshotHub;

use App\Models\Screenshot;
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
        $this->screenshot->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'Screenshot successfully deleted!']);

        return redirect()->route('screenshot-hub.index');
    }
}
