<?php

namespace App\Orchid\Layouts\Bulk\Valuation;

use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;



class Valuation extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    public $target = 'asset_valuation';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [

                TD::make('asset.name', __('Asset Name'))->sort()
                    ->render(fn($valuation) => $valuation->asset->name ?? '-'), // Use arrow function for simplicity
            
                TD::make('depend_on', __('Depended On'))
                    ->render(fn($valuation) => $valuation->depend_on ?? '-'), // Use arrow function for simplicity
                
                
                
                TD::make('depended_asset', __('Depended Asset'))
                    ->render(fn($valuation) => $valuation->depended_asset ?? '-'),
                
                TD::make('confidential', __('Confidential'))
                    ->render(function($valuation) {
                        return $this->renderValue($valuation->confidential);

                    }),
                
                TD::make('integrity', __('Integrity'))
                    ->render(function($valuation){
                        return $this->renderValue($valuation->integrity);

                    }),
                
                TD::make('availability', __('Availability'))
                    ->render(function($valuation){
                        return $this->renderValue($valuation->availability);

                    }),

                TD::make('asset_value', __('Asset Value'))
                    ->render(function($valuation){
                        return $this->renderValue($valuation->asset_value_5);
                    }),

                TD::make('edit', __(''))
                ->render(function ($valuation) {
                    return ModalToggle::make(__('Edit'))
                    ->modal('modalValuation')
                    ->modalTitle($valuation->asset->name ?? '-')
                    ->method('save')
                    ->type(Color::INFO())
                    ->asyncParameters([
                        'valuation' => $valuation->id,
                    ]);
                }),
                
        ];
    }
    private function renderValue($value)
    {
        return $this->renderLevel($value, ['Low' => 'L', 'Medium' => 'M', 'High' => 'H' ]);
    }

    private function renderLevel($value, $levels)
    {
        return $levels[$value] ?? '-';
    }
}



