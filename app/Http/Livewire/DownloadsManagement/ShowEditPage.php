<?php

namespace App\Http\Livewire\DownloadsManagement;

use App\Models\Download;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowEditPage extends Component
{
    use WithFileUploads;

    public Download $download;
    // Form fields
    public string $name = '';
    public string $description = '';
    public $image;
    public $file;

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['present'],
            'image' => ['nullable', 'image', 'max:1024'],
            'file' => ['nullable', 'file', 'mimes:pdf,zip,rar', 'max:10240'],
        ];
    }

    public function mount(): void
    {
        $this->name = $this->download->name;
        $this->description = $this->download->description ?? '';
    }

    public function render()
    {
        return view('livewire.downloads-management.edit-page')->extends('layouts.app');
    }

    public function submit()
    {
        $this->validate();

        $this->download->name = $this->name;
        $this->download->description = $this->description;
        $this->download->updated_by = Auth::id();

        if (!is_null($this->image)) {
            // Delete the old image
            Storage::disk('scaleway')->delete($this->download->image_path);

            // Store the new image
            $image = $this->image->storePublicly('downloads/' . $this->download->id, 'scaleway');

            $this->download->image_path = $image;
        }

        if (!is_null($this->file)) {
            // Delete the old file
            Storage::disk('scaleway')->delete($this->download->file_path);

            // Store the new file
            $file = $this->file->store('downloads/' . $this->download->id, 'scaleway');

            $this->download->file_path = $file;
        }

        $this->download->save();

        session()->flash('alert', ['type' => 'success', 'message' => 'Download <b>' . $this->download->name . '</b> successfully updated!']);

        return redirect()->route('downloads.management.index');
    }
}
