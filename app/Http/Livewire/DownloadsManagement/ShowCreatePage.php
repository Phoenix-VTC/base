<?php

namespace App\Http\Livewire\DownloadsManagement;

use App\Models\Download;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * @property Forms\ComponentContainer $form
 */
class ShowCreatePage extends Component implements HasForms
{
    use AuthorizesRequests;
    use InteractsWithForms;

    // Form fields
    public $name = '';
    public $description = '';
    public $image = '';
    public $file = '';

    public function mount()
    {
        $this->authorize('create', Download::class);
    }

    public function render()
    {
        return view('livewire.downloads-management.create-page')->extends('layouts.app');
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
                                ->placeholder('Kenji tuning mod')
                        ]),

                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->disk('scaleway')
                                ->directory('downloads/thumbnails')
                                ->required()
                                ->label('Thumbnail image')
                                ->image()
                                ->hint('Max 2MB')
                                ->maxSize(2048),

                            Forms\Components\FileUpload::make('file')
                                ->disk('scaleway')
                                ->directory('downloads/files')
                                ->required()
                                ->hint('Max 100MB')
                                ->maxSize(102400),

                            Forms\Components\Textarea::make('description')
                                ->required()
                                ->placeholder('Super mod for all everyone to download')
                                ->maxLength(255)
                                ->rows(3)
                        ]),
                ]),
        ];
    }

    public function submit()
    {
        $validatedData = $this->form->getState();

        $download = Download::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'image_path' => $validatedData['image'],
            'file_path' => $validatedData['file'],
            'updated_by' => Auth::id(),
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => "Download <b>$download->name</b> successfully added!"]);

        return redirect()->route('downloads.management.index');
    }
}
