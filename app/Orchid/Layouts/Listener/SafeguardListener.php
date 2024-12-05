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

        return [
            
            
            Layout::rows([
                Group::make([
                    Select::make('safeguard_group')
                    ->options([
                        '' => 'Choose safeguard group',
                        'S1 Organizational Controls' => 'S1 Organizational Controls',
                        'S2 People Controls' => 'S2 People Controls',
                        'S3 Physical Controls' => 'S3 Physical Controls',
                        'S4 Technological Controls' => 'S4 Technological Controls',
                    ])
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
        $safeguardIdOptions = SafeguardOptions::getSafeguardIdOptions($selectedSafeguardGroup,'Safeguard');

        // Update repository with options
        $repository
            ->set('safeguard_type', $safeguard_type)
            ->set('safeguard_id_options', $safeguardIdOptions)
            ->set('safeguard_group', $selectedSafeguardGroup)
            ->set('safeguard_id', $request->input('safeguard_id'));

        return $repository;
    }

}
