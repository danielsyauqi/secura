<?php

namespace App\Orchid\Layouts\Listener;

use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use App\Models\Assessment\Threat;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use App\Models\Management\AssetManagement;
use Illuminate\Support\Facades\Log;

class AllSelectionListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[] 
     */
    protected $targets = ['asset_type','asset_name', 'threat_group' ,'threat.name', 'assetID', 'threat','asset' ];


    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    protected function layouts(): iterable
    {
        return [
            Layout::rows([
                
                    Select::make('asset_type')
                        ->title('Asset Type')
                        ->options([
                            '' => 'Choose Asset Type',
                            'Hardware' => 'Hardware',
                            'Software' => 'Software',
                            'Work Process' => 'Work Process',
                            'Human Resources' => 'Human Resources',
                            'Data and Information' => 'Data and Information',
                            'Services' => 'Services',
                            'Premise' => 'Premise', 
                        ])
                        ->help('Select a asset type.')
                        ->placeholder('Select asset type')
                        ->load('platform.assessment.getAssetsByType')                        // Dynamically load threats based on the selected group
                        ->canSee(empty($this->query->get('assetID'))),

                        Select::make('asset_name')
                        ->title('Current Asset')
                        ->options($this->query->get('asset_name_options', ['' => 'Choose assets'])) // Include all options in the dropdown
                        ->help('Select the current asset')
                        ->canSee(empty($this->query->get('assetID'))),


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
                        ->placeholder('Select threat group'),

                    Select::make('threat.name')
                        ->title('Current Threat')
                        ->options($this->query->get('threat_details_options', ['' => 'Choose threat details'])) // Include all options in the dropdown
                        ->help('Select the current threat')




    

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
        // Get the selected asset type from the request
        $assetType = $request->input('asset_type');
        $asset_name = $repository->get('assetID') ?? $request->input('asset_name');
        $threat_name =$request->input('threat.name');

        // Update the repository with the selected asset type



        // Fetch assets based on the selected asset type (if selected)
        $assetOptions = [];
        if ($assetType) {
            // Query the database for assets with the selected type
            $assetOptions = AssetManagement::where('type', $assetType)
                ->pluck('name', 'id')
                ->toArray();

            // Fallback message if no assets are found for the selected type
            if (empty($assetOptions)) {
                $assetOptions = ['' => 'No assets available for the selected type'];
            }

        }

      


        // Get the selected threat group from the request
        $threatGroup = $request->input('threat_group');


        // Initialize threat options with a default message
        $threatOptions = ['' => 'No threats available for the selected group'];

        // Fetch the available threats based on the selected threat group
        if ($threatGroup) {
            $threatOptions = Threat::where('threat_group', $threatGroup)
                ->where('asset_id', $asset_name)
                ->pluck('threat_name', 'id')
                ->toArray();

            if (empty($threatOptions)) {
                $threatOptions = ['' => 'No threats available for the selected group'];
            }
        }
        
        // Retrieve cookies
        $cookieAssetType = isset($_COOKIE['asset_type']) ? $_COOKIE['asset_type'] : null;

        // Check if the asset type has changed
        if ($assetType !== $cookieAssetType) {
            Log::info('Status:True');
            // Reset threat group and threat details options to default
            $repository->set('threat_group', '')
                    ->set('threat_details_options', ['' => 'No threats available for the selected group']);
        }else{
            $repository->set('threat_details_options', $threatOptions) // Set the available threats based on the selected group
                        ->set('threat_group', $threatGroup); // Store the selected threat group
        }

        setcookie('asset_type', $assetType, time() + (86400 * 30), "/"); // 86400 = 1 day

        // Log the cookie data and asset type request
        Log::info('Cookie and Request Data', [
            'cookie_asset_type' => $cookieAssetType,
            'request_asset_type' => $assetType,
        ]);
        
        // Log the threat options
        Log::info('Threat options', [
            'asset_type' => $assetType, // Store the selected asset type
            'threat_details_options' => $threatOptions, // Set the available threats based on the selected group
            'threat_group' => $threatGroup, // Store the selected threat group
        ]);

        
        


            // Update the repository with the available options
            return $repository
                ->set('asset_name', $asset_name)
                ->set('asset_name_options', $assetOptions) // Set the available asset names based on the selected type
                ->set('asset_type', $assetType) // Store the selected asset type
                ->set('threat.name', $threat_name); // Store the selected threat group
        

        
    }



}
