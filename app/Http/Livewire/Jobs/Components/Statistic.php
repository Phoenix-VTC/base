<?php

namespace App\Http\Livewire\Jobs\Components;

use Livewire\Component;

class Statistic extends Component
{
    public string $icon;

    public string $title;

    public string $content;

    public string $changeNumber;

    public bool $increased = true;

    public string $route;

    public function render()
    {
        return view('livewire.jobs.components.statistic');
    }
}
