<?php
namespace App\Orchid\Layouts\Bulk\Threat;

use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\ModalToggle;

class Threat extends Table
{

    
    public $target = 'asset_threat'; // Assuming you're passing 'groupedThreats'

    public function columns(): array
    {
        return [
            TD::make('asset.name', __('Asset Name'))->sort()
                ->render(function ($groupedThreats) {
                    return $groupedThreats->first()->asset->name ?? '-';
                }),

            TD::make('threat_group', __('Threat Group'))
                ->render(function ($groupedThreats) {
                    // Merge threat groups for each asset, remove duplicates and join with commas
                    $groupedThreatsNames = $groupedThreats->pluck('threat_group')->unique()->implode(', ');
                    return $groupedThreatsNames ?: '-';
                }),

            TD::make('threat_name', __('Threat Name'))
                ->render(function ($groupedThreats) {
                    // Merge threat names for each asset, remove duplicates and join with commas
                    $groupedThreatNames = $groupedThreats->pluck('threat_name')->unique()->implode(', ');
                    return $groupedThreatNames ?: '-';
                }),

            TD::make('edit', __(''))
                ->render(function ($groupedThreats) {
                    // Assuming there's a single asset for each group, use the first asset
                    return ModalToggle::make(__('Edit'))
                        ->modal('modalThreat')
                        ->modalTitle($groupedThreats->first()->asset->name ?? '-')
                        ->method('save')
                        ->type(Color::INFO())
                        ->asyncParameters([
                            'threat' => $groupedThreats->first()->id,
                        ]);
                }),
        ];
    }
}
