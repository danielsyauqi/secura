<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TitleAsset extends Component
{

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'blade'
        <div style="margin-top: 20px; text-align: center; font-family: Arial, sans-serif; color: #333; background-color: #f0f0f0; padding: 10px; border-radius: 5px;">
            <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">List of Assets</h1>
        </div>
        blade;
    }
}
