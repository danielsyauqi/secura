<?php

namespace App\Orchid\Screens\Bulk;

use Exception;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use Orchid\Screen\Fields\Input;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use App\Models\Management\AssetManagement;
use Illuminate\Validation\ValidationException;
use App\Orchid\Layouts\Listener\Bulk\TreatmentBulk;
use App\Models\Assessment\Treatment as TreatmentModel;
use App\Orchid\Layouts\Management\GlobalAssetSearchLayout;
use App\Orchid\Layouts\Bulk\Treatment\Treatment as TreatmentLayout;
use App\Models\Assessment\Protection as ProtectionModel;

class Treatment extends Screen
{
    public $asset;   
    public $protection;

    /**
     * @var string
     */
    public $searchQuery = '';

    public function query(): iterable
    {
        $query = TreatmentModel::with([
            'threat' => function($query) {
                $query->with(['asset' => function($query) {
                    $query->with('valuation');
                }]);
            },
            'rmsd' => function($query) {
                $query->select('id', 'threat_id', 'impact_level', 'impact_level_5', 'likelihood', 'likelihood_5', 'risk_level', 'risk_level_5', 'safeguard_id');
            },
            'protection' => function($query) {
                $query->select('id', 'threat_id', 'protection_strategy', 'protection_id', 'decision');
            }
        ])->whereHas('threat', function($query) {
            $query->whereHas('asset');
        })->whereHas('rmsd')
          ->whereHas('protection');

        $search = request('filter.search');
        $selectedType = request('filter.type');

        if ($search) {
            $query->whereHas('threat.asset', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($selectedType) {
            $query->whereHas('threat.asset', function ($q) use ($selectedType) {
                $q->where('type', $selectedType);
            });
        }

        $treatments = $query->get();

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
            'treatment' => $treatments,
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
        return redirect()->route('platform.bulk.treatment', ['filter' => ['search' => $search, 'type' => $type]]);
    }

    public function name(): ?string
    {
        return 'Risk Treatment Plan';
    }

    public function description(): ?string
    {
        return 'Assess and manage risk treatment plans associated with assets and their corresponding threats. This module allows you to identify, categorize, and track vulnerabilities to better understand and mitigate potential risks.';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Print Report'))
                ->icon('bs.printer')
                ->method('next'),
        ];
    }

    public function layout(): array
    {
        return [
            GlobalAssetSearchLayout::class,
            TreatmentLayout::class,

            Layout::modal('modalTreatment', [
                TreatmentBulk::class,
            ])->deferred('loadTreatmentModal'),

            Layout::modal('assetDescription', Layout::rows([
                Input::make('asset_description')
                    ->type('textarea')
                    ->disabled()
                    ->style('color: #43494f;')
                    ->title('Asset Description'),

                Input::make('threat_name')
                    ->type('text')
                    ->disabled()
                    ->style('color: #43494f;')
                    ->title('Threat Name'),

                Input::make('safeguard_id')
                    ->type('text')
                    ->disabled()
                    ->style('color: #43494f;')
                    ->title('Existing Safeguard'),

                Input::make('risk_level')
                    ->type('text')
                    ->disabled()
                    ->style('color: #43494f;')
                    ->title('Risk Level'),

                Input::make('risk_level_5')
                    ->type('text')
                    ->disabled()
                    ->style('color: #43494f;')
                    ->title('Risk Level Scale 5'),

                Input::make('protection')
                    ->type('text')
                    ->disabled()
                    ->style('color: #43494f;')
                    ->title('Protection ID'),
            ]))->deferred('loadAssetDescription'),
        ];
    }

    public function loadAssetDescription(AssetManagement $asset, Threat $threat, RMSD $rmsd, ProtectionModel $protection): array{
        return[
            'asset_description' => $asset->description,
            'threat_name' => $threat->threat_name,
            'safeguard_id' => $rmsd->safeguard_id,
            'risk_level' => $rmsd->risk_level,
            'risk_level_5' => $rmsd->risk_level_5,
            'protection' => $protection->protection_id,
        ];
    }

    public function save(Request $request)
    {
        $treatment_id = $request->input('treatment');
        try {
            $treatment = TreatmentModel::find($treatment_id);
            
            if ($treatment) {
                $treatment->update([
                    'id' => $treatment_id,
                    'start_date' => $request->input('start_date') ?? $treatment->start_date,
                    'end_date' => $request->input('end_date') ?? $treatment->end_date,
                    'residual_risk' => $request->input('residual_risk') ?? $treatment->residual_risk,
                    'personnel' => $request->input('personnel') ?? $treatment->personnel,
                    'scale_5' => $request->input('scale_5') ?? $treatment->scale_5
                ]);
            } else {
               Toast::error('An error occurred while saving the treatment assessment.');
            }

            Toast::info('Treatment assessment saved successfully.');
        } catch (ValidationException $e) {
            Toast::error('Validation error: ' . $e->getMessage());
        } catch (QueryException $e) {
            Toast::error('Database error: Unable to save treatment assessment.');
        } catch (Exception $e) {
            Toast::error('An unexpected error occurred while saving the treatment assessment.');
        }
    }

    public function next(){
        return redirect()->route('platform.report.printReport');
    }

    public function loadTreatmentModal(TreatmentModel $treatment): array
    {
        return [
            'start_date' => $treatment->start_date,
            'end_date' => $treatment->end_date,
            'residual_risk' => $treatment->residual_risk,
            'personnel' => $treatment->personnel,
            'scale_5' => $treatment->scale_5,
        ];
    }
}