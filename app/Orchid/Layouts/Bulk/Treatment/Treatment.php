<?php
namespace App\Orchid\Layouts\Bulk\Treatment;

use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\ModalToggle;

class Treatment extends Table
{

    public $target = 'treatment'; //

    public function columns(): array
    {
        return [
            TD::make('asset_name', __('Asset Name'))->sort()
                ->render(fn ($treatment) => ModalToggle::make($treatment->threat->asset->name)
                ->modal('assetDescription')
                ->modalTitle($treatment->threat->asset->name)
                ->asyncParameters([
                    'asset' => $treatment->threat->asset->id,
                    'threat' => $treatment->threat->id,
                    'rmsd' => $treatment->rmsd->id,
                    'protection' => $treatment->protection->id,
                ])),
        

            TD::make('decision', __('Decision'))
                ->render(function ($treatment) {
                    return $treatment->protection->decision ?? '-';
                }),
            TD::make('personnel', __('Personnel'))
                ->render(function ($treatment) {
                    return $treatment->personnel ?? '-';
                }),
            TD::make('start_date', __('Start Date'))
                ->render(function ($treatment) {
                    return $treatment->start_date ?? '-';
                }),
            TD::make('end_date', __('End Date'))
                ->render(function ($treatment) {
                    return $treatment->end_date ?? '-';
                }),
            TD::make('residual_risk', __('Residual Risk'))
                ->render(function ($treatment) {
                    return $this->renderValue($treatment->residual_risk);
                }),
            TD::make('scale_5', __('Residual Risk Scale 5'))
                ->render(function ($treatment) {
                    return $this->renderValue($treatment->scale_5);
                }),
            TD::make('edit', __(''))
                ->render(function ($treatment) {
                    return ModalToggle::make(__('Edit'))
                        ->modal('modalTreatment')
                        ->modalTitle($treatment->threat->asset->name ?? '-')
                        ->method('save')
                        ->type(Color::INFO())
                        ->asyncParameters([
                            'treatment' => $treatment->id,
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
