<?php

namespace App\Orchid\Screens\Bulk;

use Exception;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use App\Orchid\Layouts\Listener\Bulk\RiskBulk;
use App\Orchid\Layouts\Management\GlobalAssetSearchLayout;
use App\Orchid\Layouts\Bulk\Risk\Risk as RiskLayout;

class RiskCalculation extends Screen
{
    public $asset;   
    public $risk;

    /**
     * @var string
     */
    public $searchQuery = '';

    public function query(): iterable
    {
        $query = RMSD::with(['threat' => function($query) {
            $query->with('asset');
        }]);

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
            'risk' => $rmsd,
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
        return redirect()->route('platform.bulk.riskCalculation', ['filter' => ['search' => $search, 'type' => $type]]);
    }

    public function name(): ?string
    {
        return 'Asset Risk Assessment';
    }

    public function description(): ?string
    {
        return 'Assess and manage risks associated with assets and their corresponding threats. This module allows you to identify, categorize, and track risks to better understand and mitigate potential risks.';
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
            RiskLayout::class,

            Layout::modal('modalRisk', [
                RiskBulk::class,
            ])->deferred('loadRiskModal'),
        ];
    }

    public function save(Request $request)
    {
        $rmsd_id = $request->input('risk');
        try {
            $rmsd = RMSD::find($rmsd_id);
            
            if ($rmsd) {
                $rmsd->update([
                    'id' => $rmsd_id,
                    'risk_level' => $request->input('risk_level') ?? $rmsd['risk_level'],
                    'likelihood' => $request->input('likelihood') ?? $rmsd['likelihood'],
                    'risk_level_5' => $request->input('risk_level_5') ?? $rmsd['risk_level_5'],
                    'likelihood_5' => $request->input('likelihood_5') ?? $rmsd['likelihood_5'],
                ]);
            } else {
               Toast::error('An unexpected error occurred while saving the vulnerability assessment.');
            }

            Toast::info('Vulnerability assessment saved successfully.');
        } catch (ValidationException $e) {
            Toast::error('Validation error: ' . $e->getMessage());
        } catch (QueryException $e) {
            Toast::error('Database error: Unable to save vulnerability assessment.');
        } catch (Exception $e) {
            Toast::error('An unexpected error occurred while saving the vulnerability assessment.');
        }
    }

    public function next(){
        return redirect()->route('platform.bulk.protection');
    }

    public function loadRiskModal(RMSD $risk): array
    {
        return [
            'impact_level' => $risk->impact_level,
            'impact_level_5' => $risk->impact_level_5,
            'risk_level' => $risk->risk_level,
            'risk_level_5' => $risk->risk_level_5,
            'likelihood' => $risk->likelihood,
            'likelihood_5' => $risk->likelihood_5,
        ];
    }
}