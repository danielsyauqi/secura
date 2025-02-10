<?php

namespace App\Orchid\Layouts\Listener\Bulk;

use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use App\Orchid\Layouts\Assessment\VulnGroupOptions;

class VulnerableBulk extends Listener
{

    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['vuln_group'];

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    protected function layouts(): iterable
    {
        return [

           
            Layout::rows([
                    Select::make('vuln_group')
                        ->options([
                            '' => 'Choose vulnerability group',
                            'V1 Hardware' => 'V1 Hardware',
                            'V2 Software' => 'V2 Software',
                            'V3 Network' => 'V3 Network',
                            'V4 Personnel' => 'V4 Personnel',
                            'V5 Site' => 'V5 Site',
                            'V6 Organization' => 'V6 Organization',

                        ])
                        ->title('Add/Update Vulnerability Group')
                        ->help('Select the vulnerability group.'),

                    Select::make('vuln_name')
                        ->options(
                            $this->query->get('vuln_name_options', VulnGroupOptions::getVulnerabilityGroupOptions($this->query->get('vuln_group')))
                        )
                        ->title('Add/Update Vulnerability Details')
                        ->help('Select the vulnerability details.'),
            ]),
        ];
    }

    /**
     * Update state dynamically based on user input.
     *
     * @param \Orchid\Screen\Repository $repository
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Orchid\Screen\Repository
     */
    public function handle(Repository $repository, Request $request): Repository
    {
        $vulnGroup = $request->input('vuln_group');

        // Fetch dynamic options for vuln_name based on the selected vuln_group
        $vulnNameOptions = VulnGroupOptions::getVulnerabilityGroupOptions($vulnGroup);

        return $repository
            ->set('vuln_group', $vulnGroup)
            ->set('vuln_name_options', $vulnNameOptions);
    }
}
