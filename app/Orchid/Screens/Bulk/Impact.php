<?php

namespace App\Orchid\Screens\Bulk;

use Exception;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use App\Orchid\Layouts\Listener\Bulk\ImpactBulk;
use App\Orchid\Layouts\Management\GlobalAssetSearchLayout;
use App\Orchid\Layouts\Bulk\Impact\Impact as ImpactLayout;
use App\Orchid\Layouts\Bulk\Impact\ImpactS5 as ImpactS5Layout;

class Impact extends Screen
{
    public $asset;   
    public $impact;

    /**
     * @var string
     */
    public $searchQuery = '';

    public function query(): iterable
    {
        $query = RMSD::with([
            'threat' => function($query) {
                $query->with([
                    'asset' => function($query) {
                        $query->with('valuation'); // Include asset valuation
                    }
                ]);
            }
        ]);

        $search = request('filter.search');
        $selectedType = request('filter.type');

        if ($search) {
            $query->whereHas('threat.asset', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })->orWhereHas('threat', function ($q) use ($search) {
                $q->where('threat_name', 'like', "%{$search}%")
                  ->orWhere('threat_group', 'like', "%{$search}%");
            });
        }

        if ($selectedType) {
            $query->whereHas('threat.asset', function ($q) use ($selectedType) {
                $q->where('type', $selectedType);
            });
        }

        // Join with asset_valuation to ensure we only get assets with valuations
        $query->whereHas('threat.asset.valuation');

        $rmsd = $query->get();

        $assetTypes = [
            'hardware' => 'Hardware',
            'software' => 'Software',
            'work' => 'Work Process',
            'data' => 'Data and Information',
            'service' => 'Services',
            'resource' => 'Human Resources',
            'premise' => 'Premise',
        ];

        return [
            'impact' => $rmsd,
            'assetTypes' => $assetTypes,
            'selectedType' => $selectedType,
            'filter' => [
                'search' => $search,
                'type' => $selectedType
            ],
        ];
    }

    public function search(): RedirectResponse
    {
        $search = request('filter.search');
        $type = request('filter.type');
        return redirect()->route('platform.bulk.impact', ['filter' => ['search' => $search, 'type' => $type]]);
    }

    public function name(): ?string
    {
        return 'Impact Assessment';
    }

    public function description(): ?string
    {
        return 'Assess the potential business impact and severity levels of identified vulnerabilities. This assessment helps prioritize risk mitigation efforts based on the potential impact to business operations.';
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
                'Scale 3' => ImpactLayout::class,
                'Scale 5' => ImpactS5Layout::class,
            ]),


            Layout::modal('modalImpact', [
                ImpactBulk::class,
            ])->deferred('loadImpactModal'),
        ];
    }

    public function save(Request $request)
    {
        $rmsd_id = $request->input('impact');
        try {
            $rmsd = RMSD::find($rmsd_id);
            if ($rmsd) {
                $rmsd->update([
                    'id' => $rmsd_id,
                    'business_loss' => $request->input('business_loss') ?? $rmsd->business_loss,
                    'impact_level' => $request->input('impact_level') ?? $rmsd->impact_level,
                    'business_loss_5' => $request->input('business_loss_5') ?? $rmsd->business_loss_5,
                    'impact_level_5' => $request->input('impact_level_5') ?? $rmsd->impact_level_5
                ]);
            } else {
                Toast::error('No impact information.');
            }

            Toast::info('Impact assessment saved successfully.');
        } catch (ValidationException $e) {
            Toast::error('Validation error: ' . $e->getMessage());
        } catch (QueryException $e) {
            Toast::error('Database error: Unable to save impact assessment.');
        } catch (Exception $e) {
            Toast::error('An unexpected error occurred while saving the impact assessment.');
        }
    }

    public function next(){
        return redirect()->route('platform.bulk.riskCalculation');
    }

    public function loadImpactModal(RMSD $impact): array
    {
        return [
            'assetID' => $impact->threat->asset_id,
            'asset_value' => $impact->threat->asset->valuation->asset_value,
            'asset_value_5' => $impact->threat->asset->valuation->asset_value_5,
            'business_loss' => $impact->business_loss,
            'impact_level' => $impact->impact_level,
            'business_loss_5' => $impact->business_loss_5,
            'impact_level_5' => $impact->impact_level_5,
        ];
    }
}
    

