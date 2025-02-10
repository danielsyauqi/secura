<?php
namespace App\Orchid\Layouts\Bulk\Safeguard;

use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\ModalToggle;

class Safeguard extends Table
{

    public $target = 'safeguard'; //

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

            TD::make('safeguard_group', __('Safeguard Group'))
                ->render(function ($rmsd) {
                    return $rmsd->safeguard_group ?? '-';
                }),
            TD::make('safeguard_id', __('Safeguard ID'))
                ->render(function ($rmsd) {
                    return $rmsd->safeguard_id ?? '-';
                }),
            TD::make('edit', __(''))
                ->render(function ($rmsd) {
                    return ModalToggle::make(__('Edit'))
                        ->modal('modalSafeguard')
                        ->modalTitle($rmsd->threat->asset->name ?? '-')
                        ->method('save')
                        ->type(Color::INFO())
                        ->asyncParameters([
                            'safeguard' => $rmsd->id,
                        ]);
                }),
        ];
    }
}
