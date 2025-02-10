<?php

namespace App\Orchid\Screens\Bulk;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Models\Management\AssetManagement;
use App\Orchid\Layouts\Bulk\ValuationTable;
use App\Orchid\Layouts\Bulk\ValuationTableS5;
use App\Models\Assessment\Valuation as ValuationModel;
use App\Orchid\Layouts\Listener\Bulk\ValuationBulk;
use App\Orchid\Layouts\Management\GlobalAssetSearchLayout;

class Valuation extends Screen
{
    /** @var AssetManagement|null */
    public $asset;

    /** @var \Illuminate\Database\Eloquent\Collection|null */
    public $asset_valuation;
    
    public $hardware;
    public $software;
    public $work;
    public $data;
    public $service;
    public $resource;
    public $premise;

    /** @var array */
    protected const VALUATION_FIELDS = [
        'confidential', 'integrity', 'availability', 'asset_value',
        'depend_on', 'depended_asset', 'confidential_5', 'integrity_5', 'availability_5', 'asset_value_5'
    ];


    /** @var array */
    protected $scale5Data = [];

    /** @var array */
    protected $valuationData = [];

    public function query(): array
    {
        return 
        
        
        $this->loadData();
        
    }


    private function loadModels(): void
    {
        // Load all valuations with their associated assets
        $query = ValuationModel::with('asset');

        // Apply search filter if exists
        $search = request('filter.search');
        if ($search) {
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $assets = $query->get();
        
        // Set variables for each asset type
        $this->hardware = $assets->where('type', 'Hardware');
        $this->software = $assets->where('type', 'Software');
        $this->work = $assets->where('type', 'Work Process');
        $this->data = $assets->where('type', 'Data and Information');
        $this->service = $assets->where('type', 'Services');
        $this->resource = $assets->where('type', 'Human Resources');
        $this->premise = $assets->where('type', 'Premise');

        $this->asset_valuation = $assets;
    }

    

    public function search(): RedirectResponse
    {
        $search = request('filter.search');
        return redirect()->route('platform.bulk.valuation', ['filter' => ['search' => $search]]);
    }

    /**
     * Handle the asset search
     */
    public function searchAsset(string $value = null): void
    {
        // The search will be handled automatically through the request
        // as we're using request('asset_search') in loadModels()
    }

    private function loadData(): array
    {
        $this->loadModels();
        $this->loadValuationData();
        return [
            'asset_valuation' => $this->asset_valuation, // This will contain all valuations for the table
        ];
    }

    private function loadValuationData(): void
    {
        $valuation = $this->asset_valuation->first();
        foreach (self::VALUATION_FIELDS as $field) {
            $this->valuationData[$field] = $valuation?->$field;
        }
    }

    private function buildValuationData(Request $request): array
    {
        $valuationData = [];
        foreach (self::VALUATION_FIELDS as $field) {
            $valuationData[$field] = $request->input($field);
        }

        return $valuationData;
    }

    private function saveValuationData(Request $request): ValuationModel
    {
        $valuationData = $this->buildValuationData($request);
        $id = $request->input('valuation');

        return ValuationModel::updateOrCreate(
            ['id' => $id],
            $valuationData
        );
    }

    public function name(): ?string
    {
        return 'Valuation of Asset (Bulk Edit)';
    }

    public function description(): ?string
    {
        return 'The valuation of an asset is a crucial initial step in the overall assessment process. It involves determining the monetary value and importance of the asset, which forms the basis for further risk analysis and decision-making.';
    }

    public function commandBar(): array
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
            ]),
           
            Layout::modal('modalValuation', ValuationBulk::class)
                ->deferred('loadValuationModal'),

        ];
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
    



    public function save(Request $request): void
    {
        try {
            $this->saveValuationData($request);
            $resetFlag = $this->handleAssetValueChanges($request);
            $this->showSuccessMessage($resetFlag);
        } catch (\Exception $e) {
            Log::error('Error saving valuation:', ['error' => $e->getMessage()]);
            Toast::error('Error saving asset valuation: ' . $e->getMessage());
        }
    }

    private function handleAssetValueChanges(Request $request): int
    {
        $flag = 0;
        $currentValuation = $this->asset_valuation->first();

        if ($this->hasAssetValueChanged($request, 'asset_value', $currentValuation)) {
            $this->resetRMSDValues($request);
            $flag = 1;
        }

        if ($this->hasAssetValueChanged($request, 'asset_value_5', $currentValuation)) {
            $this->resetRMSDScale5Values($request);
            $flag = 2;
        }

        if ($flag > 0) {
            $valuation = ValuationModel::find($request->get('valuation'));
            Threat::where('asset_id', $valuation->asset_id)->update(['status' => 'Draft']);
        }

        return $flag;
    }

    private function hasAssetValueChanged(Request $request, string $field, ?ValuationModel $currentValuation): bool
    {
        $newValue = $request->input($field);
        $currentValue = $currentValuation?->$field ?? null;

        return $newValue !== $currentValue && $currentValue !== null;
    }

    private function showSuccessMessage(int $flag): void
    {
        switch ($flag) {
            case 1:
                Toast::info('Impact Level (Scale 3) has been reset in RMSD due to changes in Asset Value.');
                break;
            case 2:
                Toast::info('Impact Level (Scale 3) and Impact Level (Scale 5) has been reset in RMSD due to changes in Asset Value.');
                break;
            default:
                Toast::info('Asset valuation saved successfully.');
        }
    }

    public function next(): RedirectResponse
    {
        return redirect()->route('platform.bulk.rmsd', [
            'id' => $this->asset->id,
        ]);
    }

    private function resetRMSDValues(Request $request): void
    {
        $valuation = ValuationModel::find($request->get('valuation'));
        if (!$valuation) {
            return;
        }

        RMSD::whereHas('threat', function ($query) use ($valuation) {
            $query->where('asset_id', $valuation->asset_id);
        })->update([
            'impact_level' => null,
            'risk_level' => null,
            'business_loss' => null,
            'likelihood' => null,
        ]);
        
    }

    private function resetRMSDScale5Values(Request $request): void
    {
        $valuation = ValuationModel::find($request->get('valuation'));
        if (!$valuation) {
            return;
        }

        RMSD::whereHas('threat', function ($query) use ($valuation) {
            $query->where('asset_id', $valuation->asset_id);
        })->update([
            'impact_level_5' => null,
            'risk_level_5' => null,
            'likelihood_5' => null,
            'business_loss_5' => null,
        ]);
        
    }

    
}