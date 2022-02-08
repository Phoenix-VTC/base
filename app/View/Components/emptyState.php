<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class emptyState extends Component
{
    public string $image;

    public string $alt;

    /**
     * Create a new component instance.
     *
     * @param string $image
     * @param string $alt
     */
    public function __construct(string $image, string $alt)
    {
        $this->image = $image;
        $this->alt = $alt;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render()
    {
        return view('components.empty-state');
    }
}
