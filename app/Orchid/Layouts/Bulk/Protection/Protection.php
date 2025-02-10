<?php
namespace App\Orchid\Layouts\Bulk\Protection;

use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\ModalToggle;

class Protection extends Table
{

    public $target = 'protection'; //

    public function columns(): array
    {
        return [
            TD::make('asset_name', __('Asset Name'))->sort()
                ->render(function ($protection) {
                    return $protection->threat->asset->name ?? '-';
                }),

            TD::make('threat_name', __('Threat Name'))
                ->render(function ($protection) {
                    return $protection->threat->threat_name ?? '-';
                }),

            TD::make('safeguard_id', __('Existing Safeguard'))
                ->render(function ($protection) {
                    return $protection->rmsd->safeguard_id ?? '-';
                }),
            TD::make('risk_level', __('Risk Level'))
                ->render(function ($protection) {
                    return $this->renderValue($protection->rmsd->risk_level);
                }),

            TD::make('risk_level_5', __('Risk Level Scale 5'))
                ->render(function ($protection) {
                    return $this->renderValue($protection->rmsd->risk_level_5);
                }),
            TD::make('protection_id', __('Protection ID'))
                ->render(function ($protection) {
                    return $protection->protection_id ?? '-';
                }),

            TD::make('Decision', __('Decision'))
                ->render(function ($protection) {
                    return $protection->decision ?? '-';
                }),
            TD::make('edit', __(''))
                ->render(function ($protection) {
                    return ModalToggle::make(__('Edit'))
                        ->modal('modalProtection')
                        ->modalTitle($protection->threat->asset->name ?? '-')
                        ->method('save')
                        ->type(Color::INFO())
                        ->asyncParameters([
                            'protection' => $protection->id,
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
