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
    public $ImageLogoUrl;

    public function __construct(int $sims_id)
    {
        $this->ImageLogoUrl = DB::table('sims_management')
            ->where('id', $sims_id)    
            ->value('image_logo');
    }
    

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'blade'
        <div style="width: 150px; height: 150px; display: flex; align-items: center; justify-content: center; margin: 0 auto; padding-bottom:10px">
            <img src="/storage/{{ $ImageLogoUrl ?? public_path('/default-logo.png') }}" alt="Profile Photo" style="max-width: 100%; max-height: 100%; border-radius: 50%; border: 5px solid #ccc">
        </div>
        blade;
    }
}
