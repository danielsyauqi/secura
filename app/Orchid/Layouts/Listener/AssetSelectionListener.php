<?php

namespace App\Orchid\Layouts\Listener;

use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use App\Models\Assessment\Threat;
use App\Models\Management\AssetManagement;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;

class AssetSelectionListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[] 
     */
    protected $targets = ['asset_type'];

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
                        ->load('platform.assessment.getAssetsByType') // Dynamically load threats based on the selected group
                ]),

                Group::make([ 
                    Select::make('asset_name')
                        ->title('Current Asset')
                        ->options($this->query->get('asset_name_options', ['' => 'Choose assets'])) // Include all options in the dropdown
                        ->help('Select the current asset')
                        ->value($this->query->get('asset_name', ''))


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
        // Get the selected asset type from the request
        $assetType = $request->input('asset_type');
        

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

        // Update the repository with the available options
        return $repository
            ->set('asset_name_options', $assetOptions)     // Set the available asset names based on the selected type
            ->set('asset_type', $assetType);                // Store the selected asset type
    }



}
