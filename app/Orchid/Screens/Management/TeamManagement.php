<?php

namespace App\Orchid\Screens\Management;

use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use App\Models\Management\TeamMember;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use App\Models\User;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Management\MemberListLayout;

class TeamManagement extends Screen
{
    public $teamMembers;
    public static $selectedName;

    public function query(): array
    {
        // Get all user IDs that are already in the team_members table
        $existingTeamMemberUserIds = TeamMember::pluck('user_id')->toArray();

        // Get users who are not in the team_members table
        $availableUsers = User::whereNotIn('id', $existingTeamMemberUserIds)->get();

        return [
            'teamMembers' => TeamMember::all(),
            'availableUsers' => $availableUsers,
        ];
    }

    public function name(): string
    {
        return 'Team Management';
    }

    public function description(): string
    {
        return 'The SIMS team is comprised of security, ICT, and business operations experts, ensuring that SIMS, aligned with ISO 27001 standards, produces accurate risk assessments for organizational assets. 
        Each member brings specialized knowledge to manage security and operational risks effectively, allowing SIMS to support comprehensive risk mitigation strategies while meeting ISO 27001 compliance.';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Add')
                ->method('save')
                ->icon('bs.plus')
                ->type(Color::BASIC),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Group::make([
                    Select::make('selected_user_id')
                        ->title('Select User by Name')
                        ->options($this->query()['availableUsers']->pluck('name', 'id')->toArray())
                        ->empty('Select a name')
                        ->help('Select a user who has not joined yet.'),
                        
                    Input::make('sector')
                        ->title('Sector')
                        ->placeholder('Enter sector')
                        ->help('Enter the sector.'),
                ]),

                Group::make([
                    Input::make('job_function')
                        ->title('Job Function')
                        ->placeholder('Enter job function')
                        ->help('Enter the job function.'),


                    Input::make('ra_function')
                        ->title('RA Function')
                        ->placeholder('Enter RA function')
                        ->help('Enter the RA function.'),
                ]),

                
            ]),

            MemberListLayout::class,
        ];
    }

    public function save(Request $request): void
    {
        try {
            logger($request->all());


            TeamMember::create([
                'user_id' => $request->input('selected_user_id'),
                'sims_id' => 1,
                'job_function' => $request->input('job_function'),
                'sector' => $request->input('sector'),
                'ra_function' => $request->input('ra_function'),
            ]);

            Toast::info('Team member added successfully.');
        } catch (\Exception $e) {
            Toast::error('Failed to add team member: ' . $e->getMessage());
        }
    }

    public function remove(Request $request): void
    {
        try {
            $teamMember = TeamMember::findOrFail($request->input('id'));
            $teamMember->delete();

            Toast::info('Team member removed successfully.');
        } catch (\Exception $e) {
            Toast::error('Failed to remove team member: ' . $e->getMessage());
        }
    }
}