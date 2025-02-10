<?php

namespace App\Orchid\Screens\Assessment;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\ModalToggle;
use App\Orchid\Layouts\Listener\ValuationListener;
use App\Models\Assessment\Valuation as ValuationModel;
use App\Orchid\Layouts\Listener\AssetSelectionListener;
use App\Models\Management\AssetManagement;
use Illuminate\Http\RedirectResponse;

class Valuation extends Screen
{
    /** @var AssetManagement|null */
    public $asset;

    /** @var \Illuminate\Database\Eloquent\Collection|null */
    public $asset_valuation;

    /** @var array */
    protected const VALUATION_FIELDS = [
        'confidential', 'integrity', 'availability', 'asset_value',
        'depend_on', 'depended_asset', 'confidential_5', 'integrity_5', 'availability_5', 'asset_value_5'
    ];

    /** @var array */
    protected const SCALE_5_FIELDS = [
        'confidential_5', 'integrity_5', 'availability_5', 'asset_value_5'
    ];

    /** @var array */
    protected $valuationData = [];

    public function query(?int $id = null): array
    {
        if (is_null($id)) {
            Toast::warning('No asset selected. You can create a new valuation or select an asset.');
            return $this->getDefaultResponse();
        }

        return $this->loadData($id);
    }

    private function getDefaultResponse(): array
    {
        return array_merge(
            [
                'asset' => null,
                'asset_valuation' => null,
            ],
            array_fill_keys(self::VALUATION_FIELDS, null)
        );
    }

    private function loadData(int $id): array
    {
        $this->loadModels($id);
        $this->loadValuationData();

        return array_merge(
            [
                'asset' => $this->asset,
                'asset_valuation' => $this->asset_valuation,
            ],
            $this->valuationData
        );
    }

    private function loadModels(int $id): void
    {
        $this->asset = AssetManagement::findOrFail($id);
        $this->asset_valuation = ValuationModel::where('asset_id', $id)->get();
    }

    private function loadValuationData(): void
    {
        $valuation = $this->asset_valuation->first();
        foreach (self::VALUATION_FIELDS as $field) {
            $this->valuationData[$field] = $valuation?->$field;
        }
    }

    public function name(): ?string
    {
        return 'Step 1: Valuation of Asset';
    }

    public function description(): ?string
    {
        return 'The valuation of an asset is a crucial initial step in the overall assessment process. It involves determining the monetary value and importance of the asset, which forms the basis for further risk analysis and decision-making.';
    }

    public function commandBar(): array
    {
        return [
            Button::make(__('Save'))
                ->icon('save')
                ->method('save'),

            Button::make(__('Next'))
                ->icon('bs.arrow-bar-right')
                ->method('next'),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::accordion([
                'Asset Information' => $this->getAssetInformationLayout(),
            ]),
            Layout::modal('chooseAsset', AssetSelectionListener::class)
                ->title(!$this->asset ? __('Choose Asset') : __('Change Asset')),
            ValuationListener::class,
        ];
    }

    private function getAssetInformationLayout(): object
    {
        return Layout::rows([
            Group::make([
                $this->createAssetNameInput(),
                $this->createAssetTypeInput(),
            ]),
            $this->createAssetToggle(),
        ]);
    }

    private function createAssetNameInput(): object
    {
        return Input::make('asset.name')
            ->title('Asset Name')
            ->style('color: #43494f;')
            ->value($this->asset?->name)
            ->readonly();
    }

    private function createAssetTypeInput(): object
    {
        return Input::make('asset.type')
            ->title('Asset Type')
            ->style('color: #43494f;')
            ->value($this->asset?->type)
            ->readonly();
    }

    private function createAssetToggle(): object
    {
        return ModalToggle::make(!$this->asset ? __('Choose Asset') : __('Change Asset'))
            ->modal('chooseAsset')
            ->icon('bs.box-arrow-up-right')
            ->method('changeAsset')
            ->open(!$this->asset);
    }

    public function save(Request $request): void
    {
        try {
            $valuation = $this->saveValuationData($request);
            $resetFlag = $this->handleAssetValueChanges($request);
            $this->showSuccessMessage($resetFlag);
        } catch (\Exception $e) {
            Log::error('Error saving valuation:', ['error' => $e->getMessage()]);
            Toast::error('Error saving asset valuation: ' . $e->getMessage());
        }
    }

    private function saveValuationData(Request $request): ValuationModel
    {
        $valuationData = $this->buildValuationData($request);

        return ValuationModel::updateOrCreate(
            ['asset_id' => $this->asset->id],
            $valuationData
        );
    }

    private function buildValuationData(Request $request): array
    {
        $data = [];
        foreach (self::VALUATION_FIELDS as $field) {
            $data[$field] = $request->input($field) ?? $this->valuationData[$field] ?? null;
        }
        return $data;
    }

    private function handleAssetValueChanges(Request $request): int
    {
        $flag = 0;
        $currentValuation = $this->asset_valuation->first();

        if ($this->hasAssetValueChanged($request, 'asset_value', $currentValuation)) {
            $this->resetRMSDValues();
            $flag = 1;
        }

        if ($this->hasAssetValueChanged($request, 'asset_value_5', $currentValuation)) {
            $this->resetRMSDScale5Values();
            $flag = 2;
        }

        if ($flag > 0) {
            Threat::where('asset_id', $this->asset->id)->update(['status' => 'Draft']);
        }

        return $flag;
    }

    private function hasAssetValueChanged(Request $request, string $field, ?ValuationModel $currentValuation): bool
    {
        $newValue = $request->input($field);
        $currentValue = $currentValuation?->$field ?? null;

        return $newValue !== $currentValue && $currentValue !== null;
    }

    private function resetRMSDValues(): void
    {
        RMSD::whereHas('threat', function ($query) {
            $query->where('asset_id', $this->asset->id);
        })->update([
            'impact_level' => null,
            'risk_level' => null,
            'business_loss' => null,
            'likelihood' => null
        ]);
    }

    private function resetRMSDScale5Values(): void
    {
        RMSD::whereHas('threat', function ($query) {
            $query->where('asset_id', $this->asset->id);
        })->update([
            'impact_level_5' => null,
            'risk_level_5' => null,
            'business_loss_5' => null,
            'likelihood_5' => null
        ]);
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
        return redirect()->route('platform.assessment.threat', [
            'id' => $this->asset->id,
        ]);
    }

    public function changeAsset(Request $request): RedirectResponse
    {
        try {
            $asset = AssetManagement::findOrFail($request->input('asset_name'));
            return redirect()->route('platform.assessment.valuation', ['id' => $asset->id]);
        } catch (\Exception $e) {
            Log::error('Error changing asset:', ['error' => $e->getMessage()]);
            Toast::error('Error changing asset: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}