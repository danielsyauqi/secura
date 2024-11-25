<?php

namespace App\Orchid\Layouts\Listener;

use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Fields\RadioButtons;
use App\Models\Assessment\RMSD as RMSDModel;
use App\Orchid\Layouts\Assessment\SafeguardOptions;


class SafeguardListener extends Listener
{
    public RMSDModel $rmsd;
    

    public function __construct()
    {
        $this->rmsd = new RMSDModel();
    }

    protected $targets = ['safeguard_type', 'safeguard_group', 'safeguard_id'];

    protected function layouts(): iterable
    {
        // Retrieve the current threat_id from the query
        $threatId = request()->header('threat_id');  // Assuming the header key is 'threat_id'

        // Fetch the RMSD record based on the threat_id
        $rmsdRecord = $this->rmsd->firstWhere('threat_id', $threatId);
        return [
            
            
            Layout::rows([
                Group::make([
                    RadioButtons::make('safeguard_type')
                        ->options([
                            'ISMS Clause' => 'ISMS Clause',
                            'Annex A' => 'Annex A',
                        ])
                        ->placeholder('ISMS Clause')
                        ->title('Choose Safeguards Type'),
                ])->alignEnd(),

                Group::make([
                    Select::make('safeguard_group')
                    ->options($this->query->get('safeguard_group_options', ['' => 'Choose safeguard type']))
                    ->title('Add/Update Safeguard Group')
                        ->help('Select the safeguard group.'),

                    Select::make('safeguard_id')
                    ->options($this->query->get('safeguard_id_options', ['' => 'Choose safeguard ID']))
                    ->title('Add/Update Safeguard ID')
                    ->help('Select the safeguard id.')
                    
                ]),
            ]),


        ];
    }

    public function handle(Repository $repository, Request $request): Repository
    {
        $safeguard_type = $request->input('safeguard_type');
        $selectedSafeguardGroup = $request->input('safeguard_group');

        // Fetch options dynamically
        $safeguardGroupOptions = SafeguardOptions::getSafeguardGroupOptions($safeguard_type);
        $safeguardIdOptions = SafeguardOptions::getSafeguardIdOptions($selectedSafeguardGroup);

        // Update repository with options
        $repository
            ->set('safeguard_type', $safeguard_type)
            ->set('safeguard_group_options', $safeguardGroupOptions)
            ->set('safeguard_id_options', $safeguardIdOptions)
            ->set('safeguard_group', $selectedSafeguardGroup)
            ->set('safeguard_id', $request->input('safeguard_id'));

        return $repository;
    }

}
