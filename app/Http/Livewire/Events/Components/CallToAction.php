<?php

namespace App\Http\Livewire\Events\Components;

use Livewire\Component;

class CallToAction extends Component
{
    public string $tag;
    public string $title;
    public string $description;
    public string $buttonText;
    public string $buttonUrl;
    public string $backgroundColor;
    public string $textColor;

    public function render()
    {
        return view('livewire.events.components.call-to-action');
    }
}
