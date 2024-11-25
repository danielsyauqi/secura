<?php

namespace App\Orchid\Layouts\Listener;

use App\Orchid\Layouts\Assessment\ThreatGroupOptions;
use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;

class ThreatListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['threat_group'];

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
                    Select::make("threat_group")
                        ->options([
                            '' => 'Choose threat group', // Empty option for default selection
                            'T1 Force Majeure' => 'T1 Force Majeure',
                            'T2 Deliberate Act' => 'T2 Deliberate Act',
                            'T3 Human Error' => 'T3 Human Error',
                            'T4 Technical Failure' => 'T4 Technical Failure',
                        ])
                        ->title('Threat Group')
                        ->help('Select the threat group.'),

                    Select::make("threat_name")
                        ->options($this->query->get('threat_details_options', ['' => 'Choose threat details'])) // Include all options in the dropdown
                        ->title('Threat Details')
                        ->help('Select the threat details. Please make sure the details match with your threat group.'),
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
        $threatGroup = $request->input('threat_group');

        // Fetch dynamic options for vuln_name based on the selected vuln_group
        $vulnNameOptions = ThreatGroupOptions::getThreatGroupOptions($threatGroup);

        return $repository
            ->set('threat_group', $threatGroup)
            ->set('threat_details_options', $vulnNameOptions);
    
    }
}
