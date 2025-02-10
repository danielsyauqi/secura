<?php

namespace App\Orchid\Layouts\Listener\Bulk;

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


class ProtectionBulk extends Listener
{


    protected $targets = ['protection_strategy', 'protection_id', 'decision' ];

    protected function layouts(): iterable
    {

        return [
            
            
            Layout::rows([


                    Select::make('protection_strategy')
                    ->options([
                        '' => 'Choose safeguard group',
                        'S1 Organizational Controls' => 'S1 Organizational Controls',
                        'S2 People Controls' => 'S2 People Controls',
                        'S3 Physical Controls' => 'S3 Physical Controls',
                        'S4 Technological Controls' => 'S4 Technological Controls',
                    ])
                    ->title('Add/Update Protection Strategy')
                        ->help('Select the protection strategy.'),

                    Select::make('protection_id')
                    ->options($this->query->get('protection_id_options',SafeguardOptions::getSafeguardIdOptions($this->query->get('protection_strategy'),'Protection')))
                    ->title('Add/Update Protection ID')
                    ->help('Select the protection id.'),

                    Select::make('decision')
                    ->title('Decision')
                    ->options([
                        'Accept' => 'Accept',
                        'Reduce' => 'Reduce',
                        'Transfer' => 'Transfer',
                        'Avoid' => 'Avoid',
                    ])
                    ->help('Determine the decision of the protection.'),
                    

            
            ]),


        ];
    }

    public function handle(Repository $repository, Request $request): Repository
    {
        $protection_type = $request->input('protection_type');
        $selectedprotectionGroup = $request->input('protection_strategy') ?? $this->query->get('protection_strategy');
        $protection_id = $request->input('protection_id'); // Log this value to confirm


        // Fetch options dynamically
        $protectionIdOptions = SafeguardOptions::getSafeguardIdOptions($selectedprotectionGroup,'Protection');

        // Update repository with options
          

        return $repository
        ->set('protection_type', $protection_type)
        ->set('protection_id_options', $protectionIdOptions)
        ->set('protection_strategy', $selectedprotectionGroup)
        ->set('protection_id', $protection_id)
        ->set('decision', $request->input('decision'));
    }

}
