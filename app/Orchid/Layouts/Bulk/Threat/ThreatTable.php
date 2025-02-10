<?php

namespace App\Orchid\Layouts\Bulk\Threat;

use Orchid\Screen\TD;
use App\Models\Assessment\Threat as ThreatModel;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;



class ThreatTable extends Table
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
                ->cantHide(),
            
            TD::make('threat_group', __(key: 'Threat Group'))
                ->cantHide(),


            
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

                    Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->method('remove', [
                            'id' => $threat->asset_id,
                            'threat_id' => $threat->id,
                        ]),

                ])
            ),

        ];
    }
}
