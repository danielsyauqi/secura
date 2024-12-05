<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;
use App\View\Components\ProfilePhoto;


class UserEditLayout extends Rows
{
    /**
     * @var bool
     */
    protected $includeProfilePhoto;

    /**
     * UserEditLayout constructor.
     *
     * @param bool $includeProfilePhoto
     * @param $user
     */

     protected $targets = ['user'];

     
    public function __construct(bool $includeProfilePhoto = false, $user = null)
    {
        $this->includeProfilePhoto = $includeProfilePhoto;
    }

    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        
        return [


            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),
            
            Input::make('profile_photo')  // Attach the profile photo field
                ->title('Profile Photo')
                ->help('Upload a profile photo (JPG or PNG)') // Add a help message
                ->accept('.jpg,.jpeg,.png')
                ->maxFileSize(1024)
                ->type('file')
                 // Allow only 1 file

        ];
    }
}
