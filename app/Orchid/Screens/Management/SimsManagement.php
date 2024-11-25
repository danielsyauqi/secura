<?php

namespace App\Orchid\Screens\Management;


use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;

use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Storage;
use App\Orchid\Layouts\Management\MemberListLayout;
use App\Models\Management\SimsManagement as SimsManagementModel;


class SimsManagement extends Screen
{
    /**
     * Fetch data to be displayed on the screen.    
     *
     * @return array
     */

    public $sims;
    public$teamMembers;
    public $users;

     public function query(): array
     {
        $sims = SimsManagementModel::find(1); // Replace 1 with the appropriate ID or logic to fetch the correct record

        return [
            'sims' => $sims,
        ];
     }
 
     /**
      * The name of the screen displayed in the header.
      */
     public function name(): ?string
     {
         return 'SIMS Management';
     }
 
     /**
      * Display header description.
      */
     public function description(): ?string
     {
         return '

        The SIMS team is comprised of security, ICT, and business operations experts, ensuring that SIMS, aligned with ISO 27001 standards, produces accurate risk assessments for organizational assets. 
        Each member brings specialized knowledge to manage security and operational risks effectively, allowing SIMS to support comprehensive risk mitigation strategies while meeting ISO 27001 compliance.';
     }
 
 
     

        /**
        * The screen's action buttons.
        *
        * @return Action[]
        */
     public function commandBar()
     {
        return [

                            
            Button::make('Save')
            ->method('saveSims')
            ->icon('bs.check-circle')
            ->type(Color::BASIC),

        ];
     }
 
     /**
      * The screen's layout elements.
      *
      * @return \Orchid\Screen\Layout[]
      */
     public function layout(): array
     {
         return [
                Layout::rows([
                Group::make([
                    Input::make('name')
                        ->type('text')
                        ->title('Name')
                        ->required()
                        ->placeholder('Enter ISMS/ISO name')
                        ->help('Example: The Malaysian Public Sector Information Security Risk Asssessment System (MyRAM)')
                        ->value($this->sims->name)
                        ->horizontal(),

                    Input::make('standard_num')
                        ->type('text')
                        ->title('ISO Standard Number')
                        ->required()
                        ->placeholder('Enter ISO standard number')
                        ->help('Example: ISO/IEC 27001:2013')
                        ->value($this->sims->standard_num)
                        ->horizontal(),

                    
                ]),

                Group::make(array_filter([
                    Input::make('approval_date')
                        ->type('date')
                        ->title('Approval Date')
                        ->placeholder('YYYY-MM-DD')
                        ->value($this->sims->approval_date)
                        ->horizontal(),

                    Input::make('sims.approval_attachment')
                        ->type('file')
                        ->title('Approval Attachment')
                        ->horizontal(),

                    
                ])),

                Group::make([
                TextArea::make('scope_definition')
                        ->title('Scope Definition')
                        ->horizontal()
                        ->value($this->sims->scope_definition)
                        ->rows(10),

                $this->sims->approval_attachment ? Link::make('View Attachment')
                ->href(Storage::url($this->sims->approval_attachment))
                ->target('_blank')
                ->title('View Attachment')
                ->horizontal() : null,
                        

                ]),

            ]),

         ];
    }

    public function saveSims(Request $request): void
    {
        try{
            $this->validate($request, [
                'name' => 'required',
                'standard_num' => 'required',
            ]);

            

            // Find the existing record by ID
            $sims = SimsManagementModel::find(1);

           // Update the fields with the data from the request
            $sims->fill($request->only([
                'name',
                'standard_num',
                'approval_date',
                'scope_definition',
            ]));

            // Check if a file is uploaded
            if ($request->hasFile('approval_attachment')) {
                // Store the uploaded file
                $filePath = $request->file('approval_attachment')->store('approval_attachments', 'public');

                // Save the file path to the database
                $sims->approval_attachment = $filePath;
            }


        // Save the updated record back to the database
        $sims->save();

        // Display success message
        Toast::info('SIMS data has been successfully updated.');
        } catch (\Exception $e) {
            // Display error message
            Toast::error('An error occurred while updating SIMS data: ' . $e->getMessage());
    }
    }   

}
