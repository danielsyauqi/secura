<?php

namespace App\Orchid\Layouts\Assessment;

use Orchid\Screen\TD;
use App\Models\Assessment\Threat as ThreatModel;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;



class ThreatLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    public $target = 'threat_table';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [

            TD::make('threat_name', __(key: 'Threat Name'))
                ->cantHide()
                ->render(fn (ThreatModel $threat) => ModalToggle::make($threat->threat_name)),
            
            TD::make('threat_group', __(key: 'Threat Group'))
                ->cantHide()
                ->render(fn (ThreatModel $threat) => ModalToggle::make($threat->threat_group)),

            
            TD::make(__('Actions'))
            ->align(TD::ALIGN_CENTER)
            ->width('100px')
            ->render(fn (ThreatModel $threat) => DropDown::make()
                ->icon('bs.three-dots-vertical')
                ->list([

                    Link::make(__('Edit Threat'))
                        ->route('platform.assessment.threat.edit', [
                            'id' => $threat->asset_id,
                            'threat_id' => $threat->id,
                        ])
                        ->icon('bs.pencil'),


                    Link::make(__('Continue RA Wizard'))
                        ->route('platform.assessment.rmsd', [
                        'id' => $threat->asset_id,
                        'threat_id' => $threat->id,
                        ])
                        ->icon('bs.box-arrow-in-right'),

                    Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->method('remove', [
                            'id' => $threat->id,
                        ]),
            ])),

        ];
    }
}
