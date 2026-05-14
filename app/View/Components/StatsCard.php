<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatsCard extends Component
{
    public $title, $value, $percentage, $tooltip;
    /**
     * Create a new component instance.
     */
    public function __construct($title, $value, $percentage, $tooltip)
    {
        $this->title = $title;
        $this->value = $value;
        $this->percentage = $percentage;
        $this->tooltip = $tooltip;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stats-card');
    }
}
