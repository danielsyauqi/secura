<?php

namespace App\Orchid\Screens\Bulk;

use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Models\Assessment\Treatment;
use App\Models\Assessment\Protection;
use Illuminate\Http\RedirectResponse;
use App\Orchid\Layouts\Bulk\Threat\ThreatTable;
use App\Models\Assessment\Threat as ThreatModel;
use App\Orchid\Layouts\Listener\Bulk\ThreatBulk;
use App\Orchid\Layouts\Bulk\Threat\Threat as ThreatLayout;
use App\Orchid\Layouts\Management\GlobalAssetSearchLayout;

class Threat extends Screen
{
    public $asset;   
    public $asset_threat;

    /**
     * @var string
     */
    public $searchQuery = '';

    public function query(): iterable
    {
    $query = ThreatModel::with(['asset' => function($query) {
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

    // Getting the threats and grouping by asset_id
    $threats = $query->get()->groupBy('asset_id');

    $assetTypes = [
        'hardware' => 'Hardware',
        'software' => 'Software',
        'work' => 'Work Process',
        'data' => 'Data and Information',
        'service' => 'Services',
        'resource' => 'Human Resources',
        'premise' => 'Premise',
    ];

    // Filtering the threats based on asset type
    $filteredThreats = [];

    foreach ($assetTypes as $key => $type) {
        $filteredThreats[$key] = $threats->filter(function($threatsGroup) use ($type) {
            // Ensure that the first asset's type is being checked
            return $threatsGroup->first()->asset && $threatsGroup->first()->asset->type === $type;
        });
    }

    return [
        'asset_threat' => $threats,
        'assetTypes' => $assetTypes,
        'selectedType' => $selectedType,
        'filter' => [
            'search' => $search,
            'type' => $selectedType
        ],
    ] + $filteredThreats;
}


    public function search(): RedirectResponse
    {
        $search = request('filter.search');
        $type = request('filter.type');
        return redirect()->route('platform.bulk.threat', ['filter' => ['search' => $search, 'type' => $type]]);
    }


    public function name(): ?string
    {
        return 'Threat Classification (Bulk Edit)';
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
            ThreatLayout::class,

            Layout::modal('modalThreat', [
                ThreatBulk::class,
                ThreatTable::class
            ])->deferred('loadThreatModal'),
        ];
    }

    public function save(Request $request)
    {
        try {
            $assetId = $request->input('threat');
            
            $request->validate([
                'threat_name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('asset_threat')->where(function ($query) use ($assetId) {
                        return $query->where('asset_id', $assetId);
                    }), // Ignore the current record if it's being updated
                ],
                'threat_group' => 'required|string|max:255',
            ]);
            
            
            // Create or update the threat
            ThreatModel::updateOrCreate(
                [
                    'asset_id' => $assetId,
                    'threat_name' => $request->input('threat_name')
                ],
                [
                    'threat_group' => $request->input('threat_group'),
                    'status' => 'Draft'
                ]
            );

            Toast::info('Threat details saved successfully.');

            return redirect()->route('platform.bulk.threat', [
                'filter' => [
                    'search' => request('filter.search'),
                    'type' => request('filter.type')
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Toast::error('This threat already exists for the selected asset.');
            return;
        } catch (\Exception $e) {
            Toast::error('Failed to save threat details: ' . $e->getMessage());
            return;
        }
    }

    public function next(){
        return redirect()->route('platform.bulk.vulnerable');
    }

    public function loadThreatModal(ThreatModel $threat): array
    {
        return [
            'threat_table' => ThreatModel::where('asset_id', $threat->asset_id)->get(),
        ];
    }

    public function remove(Request $request): void
    {
        $id = $request->get('id');
        $threat = ThreatModel::find($id);

        if ($threat) {
            // Delete related models with threat_id
            $threats = ThreatModel::where('asset_id', $id)->get();
            foreach ($threats as $threat) {
                RMSD::where('threat_id', $threat->id)->delete();
                Protection::where('threat_id', $threat->id)->delete();
                Treatment::where('threat_id', $threat->id)->delete();
            }

            // Delete the asset
            $threat->delete();
            
            Toast::info('Asset and its related data deleted successfully.');
        } else {
            Toast::error('Failed to delete asset.');
        }
    }

    
}