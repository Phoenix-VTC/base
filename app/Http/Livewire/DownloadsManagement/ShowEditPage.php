<?php

namespace App\Http\Livewire\DownloadsManagement;

use App\Models\Download;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

/**
 * @property Forms\ComponentContainer $form
 */
class ShowEditPage extends Component implements HasForms
{
    use InteractsWithForms;

    public Download $download;

    // Form fields
    public $name = '';

    public $description = '';

    public $image;

    public $file;

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->download->name,
            'description' => $this->download->description,
        ]);
    }

    public function render()
    {
        return view('livewire.downloads-management.edit-page')->extends('layouts.app');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->placeholder('Kenji tuning mod'),
                        ]),

                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->disk('scaleway')
                                ->directory('downloads/thumbnails')
                                ->label('Thumbnail image')
                                ->image()
                                ->hint('Max 2MB')
                                ->helperText('Only upload an image if it needs to be changed')
                                ->maxSize(2048),

                            Forms\Components\FileUpload::make('file')
                                ->disk('scaleway')
                                ->directory('downloads/files')
                                ->hint('Max 100MB')
                                ->helperText('Only upload a file if it needs to be changed')
                                ->maxSize(102400),

                            Forms\Components\Textarea::make('description')
                                ->rows(3),
                        ]),
                ]),
        ];
    }

    public function submit()
    {
        $validatedData = $this->form->getState();

        $this->download->name = $validatedData['name'];
        $this->download->description = $validatedData['description'] ?: null;
        $this->download->updated_by = Auth::id();

        // Update the image if it's changed
        if (! is_null($validatedData['image'])) {
            // Delete the old image
            Storage::disk('scaleway')->delete($this->download->image_path);

            // Save the new image path
            $this->download->image_path = $validatedData['image'];
        }

        // Update the file if it's changed
        if (! is_null($validatedData['file'])) {
            // Delete the old file
            Storage::disk('scaleway')->delete($this->download->file_path);

            // Save the new file path
            $this->download->file_path = $validatedData['file'];
        }

        $this->download->save();

        session()->flash('alert', ['type' => 'success', 'message' => 'Download <b>'.$this->download->name.'</b> successfully updated!']);

        return redirect()->route('downloads.management.index');
    }
}
