<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $stats;

    public function __construct($stats)
    {
        $this->stats = $stats;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stat-component');
    }
}
