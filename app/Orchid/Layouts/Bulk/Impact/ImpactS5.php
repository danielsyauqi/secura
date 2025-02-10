<?php
namespace App\Orchid\Layouts\Bulk\Impact;

use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\ModalToggle;

class ImpactS5 extends Table
{
    public $target = 'impact';

    public function columns(): array
    {
        return [
            TD::make('asset_name', __('Asset Name'))->sort()
                ->render(function ($rmsd) {
                    return $rmsd->threat->asset->name ?? '-';
                }),

            TD::make('asset_value_5', __('Asset Value'))
                ->render(function ($rmsd) {
                    return $this->renderValue($rmsd->threat->asset->valuation->asset_value_5);
                }),

            TD::make('threat_name', __('Threat Name'))
                ->render(function ($rmsd) {
                    return $rmsd->threat->threat_name ?? '-';
                }),

            TD::make('vuln_name', __('Vulnerability Name'))
                ->render(function ($rmsd) {
                    return $rmsd->vuln_name ?? '-';
                }),

            TD::make('business_loss_5', __('Business Loss'))
                ->render(function ($rmsd) {
                    return $this->renderValue($rmsd->business_loss_5);
                }),

            TD::make('impact_level_5', __('Impact Level'))
                ->render(function ($rmsd) {
                    return $this->renderValue($rmsd->impact_level_5);
                }),

            TD::make('edit', __(''))
                ->render(function ($rmsd) {
                    return ModalToggle::make(__('Edit'))
                        ->modal('modalImpact')
                        ->modalTitle($rmsd->threat->asset->name ?? '-')
                        ->method('save')
                        ->type(Color::INFO())
                        ->asyncParameters([
                            'impact' => $rmsd->id,
                        ]);
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
