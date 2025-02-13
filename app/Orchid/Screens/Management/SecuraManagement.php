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
use Orchid\Screen\Fields\SimpleMDE;
use Illuminate\Support\Facades\Storage;
use App\Orchid\Layouts\Management\MemberListLayout;
use App\Models\Management\SecuraManagement as SecuraManagementModel;


class SecuraManagement extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */

    public $secura;
    public $users;

     public function query(): array
     {
        $secura = SecuraManagementModel::find(1); // Replace 1 with the appropriate ID or logic to fetch the correct record

        return [
            'secura' => $secura,
        ];
     }

     /**
      * The name of the screen displayed in the header.
      */
     public function name(): ?string
     {
         return 'SecuRA Management';
     }

     /**
      * Display header description.
      */
     public function description(): ?string
     {
         return '

        The SecuRA team is comprised of security, ICT, and business operations experts, ensuring that SecuRA, aligned with ISO 27001 standards, produces accurate risk assessments for organizational assets.
        Each member brings specialized knowledge to manage security and operational risks effectively, allowing SecuRA to support comprehensive risk mitigation strategies while meeting ISO 27001 compliance.';
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
            ->method('saveSecura')
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
                        ->value($this->secura->name)
                        ->horizontal(),

                    Input::make('standard_num')
                        ->type('text')
                        ->title('ISO Standard Number')
                        ->required()
                        ->placeholder('Enter ISO standard number')
                        ->help('Example: ISO/IEC 27001:2013')
                        ->value($this->secura->standard_num)
                        ->horizontal(),


                ]),

                Group::make(array_filter([
                    Input::make('approval_date')
                        ->type('date')
                        ->title('Approval Date')
                        ->placeholder('YYYY-MM-DD')
                        ->help('Enter the date of approval')
                        ->value($this->secura->approval_date)
                        ->horizontal(),

                    Input::make('secura.approval_attachment')
                        ->type('file')
                        ->help('Upload the approval attachment')
                        ->title('Approval Attachment')
                        ->horizontal(),
                ])),

                Group::make([

                    
                

                $this->secura->approval_attachment ? Link::make('View Attachment')
                ->href(Storage::url($this->secura->approval_attachment))
                ->target('_blank')
                ->style('width:19.5%; margin-left:96%;')
                ->type(Color::INFO)
                ->horizontal() : null,


                ]),

                SimpleMDE::make('scope_definition')
                    ->title('Scope Definition')
                    ->popover('Enter the scope definition')
                    ->value($this->secura->scope_definition),

            ]),

         ];
    }

    public function saveSecura(Request $request): void
    {
        try{
            $this->validate($request, [
                'name' => 'required',
                'standard_num' => 'required',
            ]);



            // Find the existing record by ID
            $secura = SecuraManagementModel::find(1);

           // Update the fields with the data from the request
            $secura->fill($request->only([
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
                $secura->approval_attachment = $filePath;
            }


        // Save the updated record back to the database
        $secura->save();

        // Display success message
        Toast::info('SecuRA data has been successfully updated.');
        } catch (\Exception $e) {
            // Display error message
            Toast::error('An error occurred while updating SecuRA data: ' . $e->getMessage());
    }
    }

}
