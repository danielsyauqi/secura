<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Support\Color;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Illuminate\Support\Facades\Storage;


class OrgProfile extends Rows
{
    /**
     * @var bool
     */

     protected $targets = ['org_profile'];

     

    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        
        return [
           
            Input::make('org_profile.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('org_logo')
                ->type('file')
                ->help('Upload the organization logo')
                ->title('Organization Logo'),
            
            Link::make('View Attachment')
                ->href(file_exists(public_path('favicon.ico')) ? "/favicon.ico" : "/default-logo.png")
                ->target('_blank')
                ->style('width:25%; justify-content:center')
                ->type(Color::INFO),
        ];
    }
}
