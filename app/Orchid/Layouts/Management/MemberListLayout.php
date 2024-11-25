<?php

namespace App\Orchid\Layouts\Management;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Models\User;
use App\Models\Management\TeamMember;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;



class MemberListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    public $target = 'teamMembers';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name',__(key: 'Name'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (TeamMember $teamMember) => new Persona($teamMember->user->presenter())),
            
                TD::make('email', __(key: 'Email'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (TeamMember $teamMember) => ModalToggle::make($teamMember->user->email)),

                TD::make('job_function', __(key: 'Job Function'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (TeamMember $teamMember) => ModalToggle::make($teamMember->job_function)),

                TD::make('job_function', __(key: 'Department'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (TeamMember $teamMember) => ModalToggle::make($teamMember->sector)),

                TD::make('job_function', __(key: 'Role'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (TeamMember $teamMember) => ModalToggle::make($teamMember->ra_function)),

                TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (TeamMember $teamMember) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'id' => $teamMember->id,
                            ]),
                    ])),
        ];
    }
}
