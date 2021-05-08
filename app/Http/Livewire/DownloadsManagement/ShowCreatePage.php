<?php

namespace App\Http\Livewire\DownloadsManagement;

use App\Models\Download;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowCreatePage extends Component
{
    use WithFileUploads;

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
            'image' => ['required', 'image', 'max:1024'],
            'file' => ['required', 'file', 'mimes:pdf,zip,rar', 'max:10240'],
        ];
    }

    public function render()
    {
        return view('livewire.downloads-management.create-page')->extends('layouts.app');
    }

    public function submit()
    {
        $this->validate();

        $download = Download::create([
            'name' => $this->name,
            'description' => $this->description ?: null,
            'image_path' => '',
            'file_path' => '',
            'updated_by' => Auth::id(),
        ]);

        $image = $this->image->storePublicly("downloads/$download->id", 'scaleway');
        $file = $this->file->store("downloads/$download->id", 'scaleway');

        $download->update([
            'image_path' => $image,
            'file_path' => $file,
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => "Download <b>$download->name</b> successfully added!"]);

        return redirect()->route('downloads.management.index');
    }
}
