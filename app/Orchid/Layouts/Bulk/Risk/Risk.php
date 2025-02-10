<?php
namespace App\Orchid\Layouts\Bulk\Risk;

use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\ModalToggle;

class Risk extends Table
{

    public $target = 'risk'; //

    public function columns(): array
    {
        return [
            TD::make('asset_name', __('Asset Name'))->sort()
                ->render(function ($rmsd) {
                    return $rmsd->threat->asset->name ?? '-';
                }),

            TD::make('threat_group', __('Threat Group'))
                ->render(function ($rmsd) {
                    return $rmsd->threat->threat_group ?? '-';
                }),

            TD::make('threat_name', __('Threat Name'))
                ->render(function ($rmsd) {
                    return $rmsd->threat->threat_name ?? '-';
                }),

            TD::make('vuln_group', __('Vulnerability Group'))
                ->render(function ($rmsd) {
                    return $rmsd->vuln_group ?? '-';
                }),

            TD::make('vuln_name', __('Vulnerability Name'))
                ->render(function ($rmsd) {
                    return $rmsd->vuln_name ?? '-';
                }),

            TD::make('impact_level', __('Impact Level'))
                ->render(function ($rmsd) {
                    return $this->renderValue($rmsd->impact_level);
                }),
            TD::make('likelihood', __('Likelihood'))
                ->render(function ($rmsd) {
                    return $this->renderValue($rmsd->likelihood);
                }),
            TD::make('risk_level', __('Risk Level'))
                ->render(function ($rmsd) {
                    return $this->renderValue($rmsd->risk_level);
                }),

            TD::make('risk_owner', __('Risk Owner'))
                ->render(function ($rmsd) {
                    return $rmsd->risk_owner ?? '-';
                }),
            TD::make('edit', __(''))
                ->render(function ($rmsd) {
                    return ModalToggle::make(__('Edit'))
                        ->modal('modalRisk')
                        ->modalTitle($rmsd->threat->asset->name ?? '-')
                        ->method('save')
                        ->type(Color::INFO())
                        ->asyncParameters([
                            'risk' => $rmsd->id,
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
