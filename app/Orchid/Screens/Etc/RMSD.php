<?php

namespace App\Orchid\Screens\Assessment;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Color;

// Screen Components
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;

// Models
use App\Models\Assessment\Threat;
use App\Models\Assessment\Valuation;
use App\Models\Management\AssetManagement;
use App\Models\Assessment\RMSD as RMSDModel;

// Listeners
use App\Orchid\Layouts\Listener\ImpactListener;
use App\Orchid\Layouts\Listener\SafeguardListener;
use App\Orchid\Layouts\Listener\VulnerableListener;
use App\Orchid\Layouts\Listener\AllSelectionListener;
use App\Orchid\Layouts\Listener\AssetSelectionListener;

class RMSD extends Screen
{
    protected const SCALE_5_DEFAULT = '[]';
    protected const DRAFT_STATUS = 'Draft';

    /** @var array */
    protected $propertyMap = [
        'safeguard_id', 'safeguard_group', 'impact_level', 
        'business_loss', 'likelihood', 'vuln_group', 'vuln_name'
    ];

    /** @var Threat */
    public $threat;
    
    /** @var AssetManagement */
    public $asset;
    
    /** @var RMSDModel */
    public $rmsd;
    
    /** @var int */
    public $assetID;
    
    /** @var string */
    public $impact_level;
    
    /** @var string */
    public $business_loss;
    
    /** @var string */
    public $asset_value_5;
    
    /** @var string */
    public $business_loss_5;
    
    /** @var string */
    public $impact_level_5;

    public function query($id = null, $threat_id = null): iterable
    {
        if (is_null($threat_id) && is_null($id)) {
            return $this->noSelectionResponse('No threat and asset selected. You can create or select a new asset and threat.');
        }

        if (is_null($threat_id)) {
            return $this->noThreatResponse($id);
        }

        return $this->getData($id, $threat_id);
    }

    private function noSelectionResponse(string $message): array
    {
        Toast::warning($message);
        return $this->defaultResponse();
    }

    private function noThreatResponse(?int $id): array
    {
        Toast::warning('No threat selected. You can create or select a new threat.');
        return array_merge($this->defaultResponse(), [
            'asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
            'assetID' => $id,
        ]);
    }

    private function defaultResponse(): array
    {
        return [
            'asset' => null,
            'assetID' => null,
            'threat' => null,
            'rmsd' => null,
            'impact_level' => null,
            'business_loss' => null,
        ];
    }

    private function getData($id, $threat_id): array
    {
        $this->loadScale5Data($id, $threat_id);
        $rmsdData = $this->getRMSDData($threat_id);

        return array_merge([
            'rmsd' => RMSDModel::where('threat_id', $threat_id)->get(),
            'threat' => Threat::find($threat_id),
            'asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
            'assetID' => $id,
            'asset_value_5' => $this->asset_value_5,
            'business_loss_5' => $this->business_loss_5,
            'impact_level_5' => $this->impact_level_5,
            'asset_value' => optional(Valuation::where('asset_id', $id)->first())->asset_value,
        ], $rmsdData);
    }

    private function loadScale5Data($id, $threat_id): void
    {
        $scale_5 = json_decode(
            Valuation::where('asset_id', $id)->first()->scale_5 ?? self::SCALE_5_DEFAULT, 
            true
        );
        $this->asset_value_5 = $scale_5['asset_value'] ?? null;

        $threat_scale_5 = json_decode(
            RMSDModel::where('threat_id', $threat_id)->first()->scale_5 ?? self::SCALE_5_DEFAULT, 
            true
        );
        $this->business_loss_5 = $threat_scale_5['business_loss'] ?? null;
        $this->impact_level_5 = $threat_scale_5['impact_level'] ?? null;
    }

    private function getRMSDData($threat_id): array
    {
        $rmsd = RMSDModel::where('threat_id', $threat_id)->first();
        $data = [];

        foreach ($this->propertyMap as $property) {
            $data[$property] = optional($rmsd)->$property;
        }

        return $data;
    }

    public function name(): ?string
    {
        return 'Step 3: Risk Management and Safeguard Data';
    }

    public function description(): ?string
    {
        return "Risk management and data safeguarding involve strategies to identify, assess, and mitigate risks that could compromise the integrity, confidentiality, and availability of sensitive information. It includes methods for evaluating discrepancies or deviations in data, which can indicate vulnerabilities or threats to data security. Effective risk management helps to prevent unauthorized access, data breaches, and system failures, ensuring that critical information is protected through measures such as encryption, access control, monitoring, and regular audits. By proactively addressing potential risks and implementing safeguards, organizations can secure their data, maintain compliance with regulations, and ensure business continuity.";
    }

    public function commandBar(): iterable
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
            Layout::tabs([
                'Vulnerable Form' => [VulnerableListener::class],
                'Safeguards Form' => [SafeguardListener::class],
                'Impact Form' => [ImpactListener::class],
            ]),
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
            ->value(optional($this->asset)->name)
            ->popover("Asset Group: " . optional($this->asset)->type)
            ->readonly();
    }

    private function createThreatInput(): object
    {
        return Input::make('threat.name')
            ->title('Current Threat')
            ->style('color: #43494f;')
            ->help('The name of the asset threat.')
            ->value(optional($this->threat)->threat_name)
            ->popover("Threat Group: " . optional($this->threat)->threat_group)
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
            Layout::modal('chooseAssetAndThreat', AllSelectionListener::class)
                ->title(__('Choose Asset and Threat')),
            Layout::modal('chooseThreat', AllSelectionListener::class)
                ->title(__('Choose Threat')),
            Layout::modal('assetModal', AssetSelectionListener::class)
                ->title('Change Asset'),
        ];
    }

    public function save(Request $request)
    {
        try {
            $flag = 0;
            Log::info('Request data:', $request->all());

            $this->saveRMSDData($request, $flag);
            $this->showSaveToast($flag);
        } catch (\Exception $e) {
            Log::error('Error saving RMSD: ' . $e->getMessage());
            Toast::error('An error occurred while saving the RMSD: ' . $e->getMessage());
        }
    }

    private function saveRMSDData(Request $request, int &$flag): void
    {
        $json = json_encode([
            'business_loss' => $request->input('business_loss_5'),
            'impact_level' => $request->input('impact_level_5'),
        ]);

        $data = $this->prepareRMSDData($request, $json);
        
        RMSDModel::updateOrCreate(
            ['threat_id' => $this->threat->id],
            $data
        );

        $this->resetRiskLevelIfNeeded($request, $flag);
    }

    private function prepareRMSDData(Request $request, string $json): array
    {
        $data = [];
        foreach ($this->propertyMap as $property) {
            $data[$property] = $request->input($property) ?? optional($this->rmsd->first())->$property;
        }
        $data['scale_5'] = $json ?? optional($this->rmsd->first())->scale_5;
        
        return $data;
    }

    private function resetRiskLevelIfNeeded(Request $request, int &$flag): void
    {
        if ($this->shouldResetScale3($request)) {
            RMSDModel::where('threat_id', $this->threat->id)
                ->update(['risk_level' => null, 'likelihood' => null]);
            $flag = 1;
        }

        if ($this->shouldResetScale5($request)) {
            RMSDModel::where('threat_id', $this->threat->id)
                ->update(['scale_5' => ['risk_level' => null, 'likelihood' => null]]);
            $flag = 2;
        }
    }

    private function shouldResetScale3(Request $request): bool
    {
        return $request->input('business_loss') !== optional($this->rmsd->first())->business_loss 
            && optional($this->rmsd->first()) !== null;
    }

    private function shouldResetScale5(Request $request): bool
    {
        return $request->input('business_loss_5') !== $this->business_loss_5 
            && $this->business_loss_5 !== null;
    }

    private function showSaveToast(int $flag): void
    {
        if ($flag === 1 || $flag === 2) {
            $scaleText = $flag === 1 ? 'Scale 3' : 'Scale 5';
            Toast::info("Risk Level ($scaleText) has been reset in RMSD due to changes in Business Loss.");
            $this->updateThreatStatus();
        } else {
            Toast::info('RMSD saved successfully.');
        }
    }

    private function updateThreatStatus(): void
    {
        Threat::where('asset_id', $this->asset->id)
            ->update(['status' => self::DRAFT_STATUS]);
    }

    public function next(Request $request)
    {
        return redirect()->route('platform.assessment.risk', [
            'id' => $request->id,
            'threat_id' => $this->threat->id,
        ]);
    }

    public function changeThreat(Request $request)
    {
        try {
            $threatID = $request->input('threat.name');
            $assetID = $threatID ? Threat::find($threatID)->asset_id : null;

            Toast::info('Threat changed.');
            return redirect()->route('platform.assessment.rmsd', [
                'id' => $assetID,
                'threat_id' => $threatID,
            ]);
        } catch (\Exception $e) {
            Log::error('Error changing threat: ' . $e->getMessage());
            Toast::error('Threat not found.');
            return redirect()->back();
        }
    }

    public function changeAsset(Request $request)
    {
        try {
            $asset = AssetManagement::find($request->input('asset_name'));

            if ($asset) {
                return redirect()->route('platform.assessment.rmsd', ['id' => $asset->id]);
            }
            
            Toast::error('No asset found for the selected asset.');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Error changing asset: ' . $e->getMessage());
            Toast::error('An error occurred while changing the asset: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function changeAssetAndThreat(Request $request)
    {
        try {
            $asset = AssetManagement::find($request->input('asset_name'));
            $threat = Threat::find($request->input('threat_name'));

            if ($asset && $threat) {
                return redirect()->route('platform.assessment.rmsd', [
                    'id' => $asset->id,
                    'threat_id' => $threat->id,
                ]);
            }
            
            Toast::error('No threat found for the selected asset.');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Error changing asset and threat: ' . $e->getMessage());
            Toast::error('An error occurred while changing the asset: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
