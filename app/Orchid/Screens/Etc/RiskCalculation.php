<?php

namespace App\Orchid\Screens\Assessment;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\ModalToggle;
use App\Models\Management\AssetManagement;
use App\Models\Assessment\RMSD as RMSDModel;
use App\Orchid\Layouts\Listener\AllSelectionListener;
use App\Orchid\Layouts\Listener\AssetSelectionListener;
use App\Orchid\Layouts\Listener\RiskCalculationListener;
use Illuminate\Http\RedirectResponse;

class RiskCalculation extends Screen
{
    /** @var Threat|null */
    public $threat;

    /** @var AssetManagement|null */
    public $asset;

    /** @var \Illuminate\Database\Eloquent\Collection|null */
    public $rmsd;

    /** @var int|null */
    public $assetID;

    /** @var array */
    protected const SCALE_5_FIELDS = ['impact_level', 'likelihood', 'risk_level'];

    /** @var array */
    protected const RMSD_FIELDS = ['likelihood', 'risk_level', 'risk_owner'];

    /** @var array */
    protected $scale5Data = [];

    public function query(?int $id = null, ?int $threat_id = null): array
    {
        if (is_null($threat_id) && is_null($id)) {
            return $this->handleNoSelectionCase();
        }

        if (is_null($threat_id)) {
            return $this->handleNoThreatCase($id);
        }

        return $this->loadData($id, $threat_id);
    }

    private function handleNoSelectionCase(): array
    {
        Toast::warning('No threat and asset selected. You can create or select a new asset and threat.');
        return $this->getDefaultResponse();
    }

    private function handleNoThreatCase(?int $id): array
    {
        Toast::warning('No threat selected. You can create or select a new threat.');
        return array_merge(
            $this->getDefaultResponse(),
            [
                'asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
                'assetID' => $id,
            ]
        );
    }

    private function getDefaultResponse(): array
    {
        return [
            'threat' => null,
            'rmsd' => null,
            'risk_level' => null,
            'risk_owner' => null,
            'asset' => null,
            'assetID' => null,
            'likelihood_5' => null,
            'impact_level_5' => null,
            'risk_level_5' => null,
            'impact_level' => null,
            'likelihood' => null,
        ];
    }

    private function loadData(?int $id, int $threat_id): array
    {
        $this->loadModels($id, $threat_id);
        $this->loadScale5Data($threat_id);

        return [
            'rmsd' => $this->rmsd,
            'threat' => $this->threat,
            'asset' => $this->asset,
            'assetID' => $id,
            'likelihood_5' => $this->scale5Data['likelihood'] ?? null,
            'impact_level_5' => $this->scale5Data['impact_level'] ?? null,
            'risk_level_5' => $this->scale5Data['risk_level'] ?? null,
            'impact_level' => $this->rmsd?->first()?->impact_level,
            'likelihood' => $this->rmsd?->first()?->likelihood,
            'risk_level' => $this->rmsd?->first()?->risk_level,
            'risk_owner' => $this->rmsd?->first()?->risk_owner,
        ];
    }

    private function loadModels(?int $id, int $threat_id): void
    {
        $this->asset = $id ? AssetManagement::findOrFail($id) : new AssetManagement();
        $this->threat = Threat::findOrFail($threat_id);
        $this->rmsd = RMSDModel::where('threat_id', $threat_id)->get();
    }

    private function loadScale5Data(int $threat_id): void
    {
        $rmsd = RMSDModel::where('threat_id', $threat_id)->first();
        $this->scale5Data = json_decode($rmsd?->scale_5 ?? '[]', true) ?: [];
    }

    public function name(): ?string
    {
        return 'Step 4: Risk Calculation';
    }

    public function description(): ?string
    {
        return 'This step involves calculating the risk levels associated with identified threats and assets. It includes evaluating the likelihood and impact of threats to determine the overall risk level.';
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
            ...$this->getModalLayouts(),
            RiskCalculationListener::class,
        ];
    }

    private function getAssetInformationLayout(): object
    {
        return Layout::rows([
            Group::make([
                $this->createAssetInput(),
                $this->createThreatInput(),
            ]),
            Group::make([
                $this->createAssetToggle(),
                $this->createThreatToggle(),
            ]),
        ]);
    }

    private function createAssetInput(): object
    {
        return Input::make('asset.name')
            ->title('Asset Name')
            ->help('The name of the asset.')
            ->style('color: #43494f;')
            ->value($this->asset?->name)
            ->popover("Asset Group: " . $this->asset?->type)
            ->readonly();
    }

    private function createThreatInput(): object
    {
        return Input::make('threat.name')
            ->title('Current Threat')
            ->style('color: #43494f;')
            ->help('The name of the asset threat.')
            ->value($this->threat?->threat_name)
            ->popover("Threat Group: " . $this->threat?->threat_group)
            ->readonly();
    }

    private function createAssetToggle(): object
    {
        return ModalToggle::make('Change Asset')
            ->modal('assetModal')
            ->method('changeAsset')
            ->icon('bs.box-arrow-up-right');
    }

    private function createThreatToggle(): object
    {
        $buttonText = !$this->threat
            ? (!$this->asset ? __('Choose Asset and Threat') : __('Choose Threat'))
            : __('Change Threat');

        $modalName = !$this->threat && !$this->asset ? 'chooseAssetAndThreat' : 'chooseThreat';
        $methodName = !$this->threat && !$this->asset ? 'changeAssetAndThreat' : 'changeThreat';

        return ModalToggle::make($buttonText)
            ->icon('bs.box-arrow-up-right')
            ->modal($modalName)
            ->method($methodName)
            ->open(!$this->threat);
    }

    private function getModalLayouts(): array
    {
        return [
            Layout::modal('assetModal', AssetSelectionListener::class)
                ->title('Change Asset'),
            Layout::modal('chooseThreat', AllSelectionListener::class)
                ->title($this->getThreatModalTitle()),
            Layout::modal('chooseAssetAndThreat', AllSelectionListener::class)
                ->title($this->getThreatModalTitle()),
        ];
    }

    private function getThreatModalTitle(): string
    {
        if (!$this->threat) {
            return !$this->asset 
                ? __('Choose Asset and Threat')
                : __('Choose Threat');
        }
        return __('Change Threat');
    }

    public function save(Request $request): void
    {
        try {
            Log::info('Saving risk calculation:', $request->all());
            
            $rmsd = $this->saveRMSDData($request);
            $this->saveScale5Data($request, $rmsd);

            Toast::info('Risk Calculation saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving risk calculation:', ['error' => $e->getMessage()]);
            Toast::error('Error saving risk calculation: ' . $e->getMessage());
        }
    }

    private function saveRMSDData(Request $request): RMSDModel
    {
        $data = [];
        foreach (self::RMSD_FIELDS as $field) {
            $data[$field] = $request->input($field) ?? $this->rmsd?->first()?->$field;
        }

        return RMSDModel::updateOrCreate(
            ['threat_id' => $this->threat->id],
            $data
        );
    }

    private function saveScale5Data(Request $request, RMSDModel $rmsd): void
    {
        $scale5 = json_decode($rmsd->scale_5 ?? '[]', true) ?: [];
        
        foreach (self::SCALE_5_FIELDS as $field) {
            $inputField = "{$field}_5";
            $scale5[$field] = $request->input($inputField) 
                ?? $this->scale5Data[$field] 
                ?? $scale5[$field] 
                ?? null;
        }

        $rmsd->update(['scale_5' => json_encode($scale5)]);
    }

    public function next(Request $request): RedirectResponse
    {
        return redirect()->route('platform.assessment.protection', [
            'id' => $request->id,
            'threat_id' => $this->threat->id,
        ]);
    }

    public function changeThreat(Request $request): RedirectResponse
    {
        try {
            $threat = Threat::findOrFail($request->input('threat.name'));
            Toast::info('Threat changed.');
            
            return redirect()->route('platform.assessment.risk', [
                'id' => $threat->asset_id,
                'threat_id' => $threat->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error changing threat:', ['error' => $e->getMessage()]);
            Toast::error('Threat not found.');
            return redirect()->back();
        }
    }

    public function changeAssetAndThreat(Request $request): RedirectResponse
    {
        try {
            $asset = AssetManagement::findOrFail($request->input('asset_name'));
            $threat = Threat::findOrFail($request->input('threat_name'));

            return redirect()->route('platform.assessment.risk', [
                'id' => $asset->id,
                'threat_id' => $threat->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error changing asset and threat:', ['error' => $e->getMessage()]);
            Toast::error('Error changing asset and threat: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function changeAsset(Request $request): RedirectResponse
    {
        try {
            $asset = AssetManagement::findOrFail($request->input('asset_name'));
            return redirect()->route('platform.assessment.risk', ['id' => $asset->id]);
        } catch (\Exception $e) {
            Log::error('Error changing asset:', ['error' => $e->getMessage()]);
            Toast::error('Error changing asset: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
