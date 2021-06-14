<?php

namespace App\Http\Livewire\ScreenshotHub;

use App\Models\Screenshot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowCreatePage extends Component
{
    use WithFileUploads;

    // Form fields
    public string $title = '';
    public $screenshot;
    public string $description = '';
    public string $location = '';

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:30'],
            'screenshot' => ['required', 'image', 'max:2048'],
            'description' => ['present', 'string', 'max:100'],
            'location' => ['present', 'string', 'max:30'],
        ];
    }

    public function mount()
    {
        if (Screenshot::where('user_id', Auth::id())->where('created_at', '>', Carbon::parse('-24 hours'))->count()) {
            $screenshot = Screenshot::where('user_id', Auth::id())->where('created_at', '>', Carbon::parse('-24 hours'))->first();

            session()->flash('alert', [
                'type' => 'danger',
                'title' => 'You have already submitted a screenshot in the past 24 hours!',
                'message' => 'A new screenshot can be submitted after <b>' . $screenshot->created_at->add('1 day')->toDayDateTimeString() . ' GMT</b>'
            ]);

            return redirect()->route('screenshot-hub.index');
        }

        session()->now('alert', [
            'type' => 'info',
            'title' => 'Please read this before submitting a screenshot!',
            'message' => '
                - You can submit a maximum of <b>one</b> screenshot every 24 hours.<br>
                - Submissions needs to be yours. You cannot submit someone else\'s creation.<br>
                - The screenshot must be taken in either Euro Truck Simulator 2 or American Truck Simulator.
            '
        ]);
    }

    public function render()
    {
        return view('livewire.screenshot-hub.create-page')->extends('layouts.app');
    }

    public function submit()
    {
        $this->validate();

        $image_path = $this->screenshot->storePublicly('screenshot-hub-uploads', 'scaleway');

        $screenshot = Screenshot::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'image_path' => $image_path,
            'description' => $this->description,
            'location' => $this->location,
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Screenshot successfully submitted!']);

        return redirect()->route('screenshot-hub.show', $screenshot);
    }
}
