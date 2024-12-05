<?php

namespace App\Orchid\Layouts\Listener;

use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use App\Orchid\Layouts\Assessment\ThreatGroupOptions;
use Orchid\Alert\Toast;

class ThreatSelectionListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[] 
     */
    protected $targets = ['threat_group' , 'assetID'];

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    protected function layouts(): iterable
    {
        return [
            Layout::rows([
                Group::make([ 
                    Select::make('threat_group')
                        ->title('Threat Group')
                        ->options([
                            '' => 'Choose threat group', // Empty option for default selection
                            'T1 Physical Threats' => 'T1 Physical Threats',
                            'T2 Natural Threats' => 'T2 Natural Threats',
                            'T3 Infrastructure Failures' => 'T3 Infrastructure Failures',
                            'T4 Technical Failures' => 'T4 Technical Failures',
                            'T5 Human Actions' => 'T5 Human Actions',
                            'T6 Organizational Threats' => 'T6 Organizational Threats',
                        ])
                        ->help('Select a threat group.')
                        ->placeholder('Select threat group')
                        ->load('platform.assessment.getThreatsByGroup') // Dynamically load threats based on the selected group

                ]),


                Group::make([ 
                    Select::make('threat.name')
                        ->title('Current Threat')
                        ->options($this->query->get('threat_details_options', ['' => 'Choose threat details'])) // Include all options in the dropdown
                        ->help('Select the current threat')


                ]),

            ]),
        ];
    }

    /**
     * Update state
     *
     * @param \Orchid\Screen\Repository $repository
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Orchid\Screen\Repository
     */
    public function handle(Repository $repository, Request $request): Repository
    {
        // Get the selected threat group from the request
        $threatGroup = $request->input('threat_group');
        $assetId = $repository->get('assetID');



        // If no groups exist, show a fallback message
        if (empty($threatGroups)) {
            $threatGroups = ['' => 'No threat groups available'];
        }

        // Fetch the available threats based on the selected threat group
        $threatOptions = [];
        if ($threatGroup) {
            $threatOptions = Threat::where('threat_group', $threatGroup)->where('asset_id', $assetId)->pluck('threat_name', 'id')->toArray();

            if (empty($threatOptions)) {
                $threatOptions = ['' => 'No threats available for the selected group'];
            }
        }

        // Update the repository with the options
        return $repository
            ->set('threat_details_options', $threatOptions)       // Set the available threats based on the selected group
            ->set('threat_group', $threatGroup);                  // Store the selected threat group
    }


}
