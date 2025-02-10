<?php
namespace App\Orchid\Layouts\Bulk\Vulnerable;

use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\ModalToggle;

class Vulnerable extends Table
{

    public $target = 'vulnerable'; //

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

            TD::make('edit', __(''))
                ->render(function ($rmsd) {
                    return ModalToggle::make(__('Edit'))
                        ->modal('modalVulnerable')
                        ->modalTitle($rmsd->threat->asset->name ?? '-')
                        ->method('save')
                        ->type(Color::INFO())
                        ->asyncParameters([
                            'vulnerable' => $rmsd->id,
                        ]);
                }),
        ];
    }
}
