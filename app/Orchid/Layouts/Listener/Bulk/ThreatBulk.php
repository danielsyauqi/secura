<?php

namespace App\Orchid\Layouts\Listener\Bulk;


use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Select;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use App\Orchid\Layouts\Assessment\ThreatGroupOptions;
use App\Orchid\Layouts\Assessment\ThreatLayout as ThreatTable;


class ThreatBulk extends Listener
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
                    Select::make("threat_group")
                        ->options([
                            '' => 'Choose threat group', // Empty option for default selection
                            'T1 Physical Threats' => 'T1 Physical Threats',
                            'T2 Natural Threats' => 'T2 Natural Threats',
                            'T3 Infrastructure Failures' => 'T3 Infrastructure Failures',
                            'T4 Technical Failures' => 'T4 Technical Failures',
                            'T5 Human Actions' => 'T5 Human Actions',
                            'T6 Organizational Threats' => 'T6 Organizational Threats',
                        ])
                        ->title('Threat Group')
                        ->help('Select the threat group.'),

                    Select::make("threat_name")
                        ->options($this->query->get('threat_details_options', ['' => 'Choose threat details'])) // Include all options in the dropdown
                        ->title('Threat Details')
                        ->help('Select the threat details. Please make sure the details match with your threat group.'),
                        
                    
                        Button::make(__('Add Threat'))
                        ->icon('plus')
                        ->type(Color::PRIMARY)
                        ->method('save'),
                    
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
        $threatNameOptions = ThreatGroupOptions::getThreatGroupOptions($threatGroup);

        return $repository
            ->set('threat_group', $threatGroup)
            ->set('threat_details_options', $threatNameOptions);
    
    }
}

