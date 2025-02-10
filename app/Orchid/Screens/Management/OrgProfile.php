<?php

namespace App\Orchid\Screens\Management;

use App\Models\OrgProfile as ManagementOrgProfile;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\View\Components\ImageLogo;
use App\Orchid\Layouts\User\OrgProfile as OrgLayout;
class OrgProfile extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */

    public $orgProfile;
    public $users;

     public function query(): array
     {
        $orgProfile = ManagementOrgProfile::find(1);

        return [
            'org_profile' => $orgProfile,
        ];
     }

     /**
      * The name of the screen displayed in the header.
      */
     public function name(): ?string
     {
         return 'Organization Profile';
     }

     /**
      * Display header description.
      */
     public function description(): ?string
     {
         return '
        The SecuRA team is comprised of security, ICT, and business operations experts, ensuring that SecuRA, aligned with ISO 27001 standards, produces accurate risk assessments for organizational assets.
        Each member brings specialized knowledge to manage security and operational risks effectively, allowing SecuRA to support comprehensive risk mitigation strategies while meeting ISO 27001 compliance.
        Use this settings page to update the organization name and logo, ensuring that all documentation and branding are current and accurate. ' ;
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
            ->method('save')
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
            Layout::component(ImageLogo::class),

            Layout::block(OrgLayout::class)
                ->title(__('Profile Information'))
                ->description(__('Update your account\'s profile information and email address.'))
         ];
    }

    public function save(Request $request): void
    {
        try {
            // Find or create the organization profile (assuming there's only one)
            $orgProfile = ManagementOrgProfile::firstOrCreate(['id' => 1]);

            // Update the fields with the data from the request
            $orgProfile->fill([
                'name' => $request->input('org_profile.name'), // Access nested data properly
            ]);
            
            $orgProfile->save();

            // Handle the uploaded logo
            if ($request->hasFile('org_logo')) {
                // Move and rename the uploaded file to 'favicon.ico'
                $request->file('org_logo')->move(public_path(), 'favicon.ico');
                
                // Display success message
                Toast::info('The logo has been updated and saved as favicon.ico.');
            }

            // Display success message
            Toast::info('Organizational data has been successfully updated.');
        } catch (\Exception $e) {
            // Display error message
            Toast::error('An error occurred while updating organizational data: ' . $e->getMessage());
        }
    }

}
