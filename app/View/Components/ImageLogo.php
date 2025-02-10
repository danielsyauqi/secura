<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class ImageLogo extends Component
{
    /**
     * Create a new component instance.
     */
    
        //

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'blade'
        <div style="width: 150px; height: 150px; display: flex; align-items: center; justify-content: center; margin: 0 auto; padding-bottom:10px">
            <img src="{{ file_exists(public_path('/favicon.ico')) ? asset('favicon.ico') : asset('default-logo.png') }}" alt="Profile Photo" style="max-width: 100%; max-height: 100%; border-radius: 50%; border: 5px solid #ccc; padding: 10px;">
        </div>
        blade;
    }
}
