<?php

namespace App\Orchid\Layouts\Management;

use App\Models\Management\AssetManagement;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Actions\Button;

class AssetSearchLayout extends Rows
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
                    ->placeholder('Search by name, type, location...')
                    ->help('Press Enter to search')
                    ->value(request('filter.search')),
                    
               
            ]),

            Button::make('Search')
            ->icon('magnifier')
            ->method('search')
            ->class('btn btn-primary')
        ];
    }
}
