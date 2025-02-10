<?php

namespace App\Orchid\Layouts\Management;

use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use App\Models\Management\AssetManagement;

class GlobalAssetSearchLayout extends Rows
{


    /**
     * Get the fields for the layout.
     *
     * @return array
     */
    protected function fields(): array
    {
        return [
            Group::make([
                Input::make('filter.search')
                    ->type('search')
                    ->title('Search Assets')
                    ->placeholder('Search by name...')
                    ->help('Press Enter to search')
                    ->value(request('filter.search')),

                    Select::make('filter.type')
                    ->title('Select Asset Type')
                    ->options([
                        '' => 'All Types',
                        'Hardware' => 'Hardware',
                        'Software' => 'Software',
                        'Work Process' => 'Work Process',
                        'Data and Information' => 'Data and Information',
                        'Services' => 'Services',
                        'Human Resources' => 'Human Resources',
                        'Premise' => 'Premise',
                    ])
                    ->empty('Select Type')
                    ->help('Select an asset type to filter')
                    ->onChange('filterByType'),
    
            ]),

            Button::make('Search')
            ->icon('magnifier')
            ->method('search')
            ->class('btn btn-primary')
        ];
    }
}
