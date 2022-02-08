<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InfoCard extends Component
{
    public string $title;

    public string $description;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param string $description
     */
    public function __construct(string $title, string $description = '')
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.info-card');
    }
}
