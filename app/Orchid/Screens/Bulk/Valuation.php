<?php

namespace App\Orchid\Screens\Bulk;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use Orchid\Screen\Fields\Select;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\RedirectResponse;
use App\Orchid\Layouts\Bulk\Valuation\Valuation as ValuationLayout;
use App\Orchid\Layouts\Bulk\Valuation\ValuationS5;

use App\Orchid\Layouts\Listener\Bulk\ValuationBulk;
use App\Models\Assessment\Valuation as ValuationModel;
use App\Orchid\Layouts\Management\GlobalAssetSearchLayout;

class Valuation extends Screen
{
    public $asset;   
    public $asset_valuation;

    /**
     * @var string
     */
    public $searchQuery = '';

    public function query(): iterable
    {
        $query = ValuationModel::with(['asset' => function($query) {
            $query->select('id', 'name', 'type');
        }]);
        
        $search = request('filter.search');
        $selectedType = request('filter.type');

        if ($search) {
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($selectedType) {
            $query->whereHas('asset', function ($q) use ($selectedType) {
                $q->where('type', $selectedType);
            });
        }

        $valuations = $query->get();

        $assetTypes = [
            'hardware' => 'Hardware',
            'software' => 'Software',
            'work' => 'Work Process',
            'data' => 'Data and Information',
            'service' => 'Services',
            'resource' => 'Human Resources',
            'premise' => 'Premise',
        ];
        
        $filteredValuations = [];
        
        foreach ($assetTypes as $key => $type) {
            $filteredValuations[$key] = $valuations->filter(function($valuation) use ($type) {
                return $valuation->asset && $valuation->asset->type === $type;
            });
        }

        return [
            'asset_valuation' => $valuations,
            'assetTypes' => $assetTypes,
            'selectedType' => $selectedType,
            'filter' => [
                'search' => $search,
                'type' => $selectedType
            ],
        ]+ $filteredValuations;
    }

    public function search(): RedirectResponse
    {
        $search = request('filter.search');
        $type = request('filter.type');
        return redirect()->route('platform.bulk.valuation', ['filter' => ['search' => $search, 'type' => $type]]);
    }


    public function name(): ?string
    {
        return 'Valuation of Asset (Bulk Edit)';
    }

    public function description(): ?string
    {
        return 'The valuation of an asset is a crucial initial step in the overall assessment process. This step involves determining the monetary value or worth of the asset. Accurate valuation is essential as it forms the basis for further analysis and decision-making regarding the asset. The valuation process may involve various methods and techniques depending on the type of asset and the context in which the valuation is being performed.';
    }

    public function commandBar(): iterable
    {
        return [

            Button::make(__('Next'))
                ->icon('bs.arrow-bar-right')
                ->method('next'),
        ];
    }

    public function layout(): array
    {
        return [

            GlobalAssetSearchLayout::class,
            Layout::tabs([
                'Scale 3' => ValuationLayout::class,
                'Scale 5' => ValuationS5::class,
            ]),

            Layout::modal('modalValuation', ValuationBulk::class)
                ->deferred('loadValuationModal'),
        ];
    }

    public function save(Request $request)
    {
        try {
            $flag = 0;
            $assetId = $request->input('valuation');
            
            // Get the current valuation record if it exists
            $currentValuation = ValuationModel::where('asset_id', $assetId)->first();
            
            // Update the asset_valuation property
            $this->asset_valuation = $currentValuation ? collect([$currentValuation]) : collect([]);

            // Prepare the data for update
            $data = [
                'depend_on' => $request->input('depend_on'),
                'depended_asset' => $request->input('depended_asset'),
                'confidential' => $request->input('confidential'),
                'integrity' => $request->input('integrity'),
                'availability' => $request->input('availability'),
                'asset_value' => $request->input('asset_value'),
                'confidential_5' => $request->input('confidential_5'),
                'integrity_5' => $request->input('integrity_5'),
                'availability_5' => $request->input('availability_5'),
                'asset_value_5' => $request->input('asset_value_5'),
            ];

            // Remove null values to prevent overwriting existing data with nulls
            $data = array_filter($data, function ($value) {
                return $value !== null;
            });

            ValuationModel::updateOrCreate(
                ['asset_id' => $assetId],
                $data
            );

            // Check if asset_value has changed
            if ($currentValuation && 
                $request->input('asset_value') !== null && 
                $request->input('asset_value') !== $currentValuation->asset_value) {
                
                RMSD::whereHas('threat', function ($query) use ($assetId) {
                    $query->where('asset_id', $assetId);
                })->update(['impact_level' => null, 'risk_level' => null, 'business_loss' => null, 'likelihood' => null]);

                $flag = 1;
            }

            // Check if asset_value_5 has changed
            if ($currentValuation && 
                $request->input('asset_value_5') !== null && 
                $request->input('asset_value_5') !== $currentValuation->asset_value_5) {
                
                RMSD::whereHas('threat', function ($query) use ($assetId) {
                    $query->where('asset_id', $assetId);
                })->update(['impact_level_5' => null, 'risk_level_5' => null, 'business_loss_5' => null, 'likelihood_5' => null]);

                $flag = 2;
            }

            if ($flag === 1) {
                Toast::info('Impact Level (Scale 3) has been reset in RMSD due to changes in Asset Value.');
                Threat::where('asset_id', $assetId)->update(['status' => 'Draft']);
            } else if ($flag === 2) {
                Toast::info('Impact Level (Scale 5) has been reset in RMSD due to changes in Asset Value.');
                Threat::where('asset_id', $assetId)->update(['status' => 'Draft']);
            } else {
                Toast::info('Asset valuation saved successfully.');
            }

            return redirect()->route('platform.bulk.valuation', [
                'filter' => [
                    'search' => request('filter.search'),
                    'type' => request('filter.type')
                ]
            ]);

        } catch (\Exception $e) {
            Toast::error('An error occurred while saving the asset valuation: ' . $e->getMessage());
            return;
        }
    }

    public function next(){
        return redirect()->route('platform.bulk.threat');
    }

    public function loadValuationModal(ValuationModel $valuation): array
    {
        return [
            'confidential' => $valuation->confidential,
            'integrity' => $valuation->integrity,
            'availability' => $valuation->availability,
            'asset_value' => $valuation->asset_value,
            'depend_on' => $valuation->depend_on,
            'depended_asset' => $valuation->depended_asset,
            'confidential_5' => $valuation->confidential_5,
            'integrity_5' => $valuation->integrity_5,
            'availability_5' => $valuation->availability_5,
            'asset_value_5' => $valuation->asset_value_5,
        ];
    }

    
}