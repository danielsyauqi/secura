<?php

namespace App\Orchid\Layouts\Bulk\Valuation;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Color;

class ValuationS5 extends Table
{
    public $target = 'asset_valuation';

    public function columns(): array
    {
        return [
            TD::make('asset.name', __('Asset Name'))->sort()
                ->render(fn($valuation) => $valuation->asset->name ?? '-'),

            TD::make('depend_on', __('Depended On'))
                ->sort()
                ->render(function ($valuation) {
                    return ModalToggle::make($valuation->depend_on ?? '-')
                        ->modal('ValuationModal')
                        ->modalTitle('Asset Valuation')
                        ->method('save')
                        ->asyncParameters(['valuation_id' => $valuation->id]);
                }),

            TD::make('depended_asset', __('Depended Asset'))
                ->render(fn($valuation) => $valuation->depended_asset ?? '-'),

            TD::make('confidential_5', __('Confidential'))
                ->render(function ($valuation) {
                    return $this->renderValue($valuation->confidential_5);
                }),

            TD::make('integrity_5', __('Integrity'))
                ->render(function ($valuation) {
                    return $this->renderValue($valuation->integrity_5);
                }),

            TD::make('availability_5', __('Availability'))
                ->render(function ($valuation) {
                    return $this->renderValue($valuation->availability_5);
                }),

            TD::make('asset_value_5', __('Asset Value'))
                ->render(function ($valuation) {
                    return $this->renderValue($valuation->asset_value_5);
                }),

            TD::make('edit', __(''))
                ->render(function ($valuation) {
                    return ModalToggle::make(__('Edit'))
                        ->modal('modalValuation')
                        ->modalTitle($valuation->asset->name ?? '-')
                        ->method('save')
                        ->type(Color::INFO())
                        ->asyncParameters(['modal' => $valuation->id]);
                }),
        ];
    }

    private function renderValue($value)
    {
        return $this->renderLevel($value, ['Very Low' => 'VL', 'Low' => 'L', 'Medium' => 'M', 'High' => 'H' , 'Very High' => 'VH']);
    }

    private function renderLevel($value, $levels)
    {
        return $levels[$value] ?? '-';
    }
}