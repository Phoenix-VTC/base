<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Request;

class Dropdown extends Component
{
    public string $title;

    public string $activeRoute;

    public string $icon;

    public array $items;

    public bool $showDropdown = false;

    public int $unreadCount = 0;

    public function mount(): void
    {
        $this->showDropdown = Request::routeIs($this->activeRoute);
    }

    public function render()
    {
        return view('livewire.components.dropdown');
    }
}
