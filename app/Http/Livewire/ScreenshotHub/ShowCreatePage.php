<?php

namespace App\Http\Livewire\ScreenshotHub;

use App\Models\Screenshot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

    public function mount(): void
    {
        session()->now('alert', ['type' => 'info', 'title' => 'Please read this before submitting a screenshot!', 'message' => 'Insert some text, guidelines and rules here. Or just a random shiba fact.']);
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
