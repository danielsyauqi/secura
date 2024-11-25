<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Picture;


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
     */
    public function __construct(bool $includeProfilePhoto = false)
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
        
        $fields = [
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
        ];

        if ($this->includeProfilePhoto) {
            $fields[] = Input::make('user.profile_photo')
                ->type('file') // Change this to 'file' to allow file uploads
                ->title(__('Profile Photo'))
                ->maxFiles(1);
        }


        return $fields;
    }
}
