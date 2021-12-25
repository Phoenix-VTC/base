<?php

namespace App\Http\Livewire\ScreenshotHub;

use App\Models\Screenshot;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowCreatePage extends Component implements HasForms
{
    use InteractsWithForms;

    // Form fields
    public $title;
    public $screenshot;
    public $description;
    public $location;

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
    }

    public function render()
    {
        return view('livewire.screenshot-hub.create-page')->extends('layouts.app');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->maxLength(30)
                                ->placeholder('My awesome truck')
                        ]),

                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\FileUpload::make('screenshot')
                                ->disk('scaleway')
                                ->directory('screenshot-hub-uploads')
                                ->required()
                                ->label('Screenshot')
                                ->image()
                                ->hint('Max 2MB')
                                ->maxSize(2048)
                        ]),

                    Forms\Components\Textarea::make('description')
                        ->maxLength(100)
                        ->rows(3)
                        ->columnSpan([
                            'sm' => 1,
                            'md' => 2,
                        ])
                        ->placeholder('A small, optional description that describes or provides information about your screenshot. Max 100 characters.'),

                    Forms\Components\Grid::make()
                        ->columns(1)
                        ->schema([
                            Forms\Components\TextInput::make('location')
                                ->maxLength(30)
                                ->hint('Where the picture was taken, optional')
                                ->placeholder('Amsterdam, the Netherlands')
                        ]),
                ]),
        ];
    }

    public function submit()
    {
        $validatedData = $this->form->getState();

        $screenshot = Screenshot::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'image_path' => $validatedData['screenshot'],
            'description' => $validatedData['description'],
            'location' => $validatedData['location'],
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Screenshot successfully submitted!']);

        return redirect()->route('screenshot-hub.show', $screenshot);
    }
}
