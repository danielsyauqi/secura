<?php

namespace App\Orchid\Screens\Assessment;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;

// Screen Components
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;

// Models
use App\Models\Assessment\Threat;
use App\Models\Assessment\Valuation;
use App\Models\Assessment\RMSD as RMSDModel;
use App\Models\Assessment\Protection as ProtectionModel;
use App\Models\Management\AssetManagement;

// Listeners
use App\Orchid\Layouts\Listener\ProtectionListener;
use App\Orchid\Layouts\Listener\AllSelectionListener;
use App\Orchid\Layouts\Listener\AssetSelectionListener;

class Protection extends Screen
{
    /** @var array */
    protected const PROTECTION_FIELDS = ['protection_strategy', 'protection_id', 'decision'];

    /** @var Threat */
    public $threat;
    
    /** @var AssetManagement */
    public $asset;
    
    /** @var RMSDModel */
    public $rmsd;
    
    /** @var int */
    public $assetID;
    
    /** @var Valuation */
    public $valuation;
    
    /** @var ProtectionModel|null */
    public $protection;
    
    /** @var string */
    public $decision;
    
    /** @var array */
    protected $fields = self::PROTECTION_FIELDS;

    /**
     * Query data for the screen
     *
     * @param int|null $id
     * @param int|null $threat_id
     * @return array
     */
    public function query($id = null, $threat_id = null): iterable
    {
        if (is_null($threat_id) && is_null($id)) {
            return $this->handleNoSelectionCase();
        }

        if (is_null($threat_id)) {
            return $this->handleNoThreatCase($id);
        }

        return $this->loadData($id, $threat_id);
    }

    /**
     * Handle case when no selection is made
     *
     * @return array
     */
    private function handleNoSelectionCase(): array
    {
        Toast::warning('No threat and asset selected. You can create or select a new asset and threat.');
        return $this->getDefaultResponse();
    }

    /**
     * Handle case when no threat is selected
     *
     * @param int|null $id
     * @return array
     */
    private function handleNoThreatCase(?int $id): array
    {
        Toast::warning('No threat selected. You can create or select a new threat.');
        return array_merge(
            $this->getDefaultResponse(),
            ['asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
             'assetID' => $id]
        );
    }

    /**
     * Get default response array
     *
     * @return array
     */
    private function getDefaultResponse(): array
    {
        return array_merge([
            'asset' => null,
            'assetID' => null,
            'threat' => null,
            'rmsd' => null,
            'valuation' => null,
        ], array_fill_keys($this->fields, null));
    }

    /**
     * Load data for the screen
     *
     * @param int|null $id
     * @param int|null $threat_id
     * @return array
     */
    private function loadData(?int $id, ?int $threat_id): array
    {
        $this->loadModels($id, $threat_id);
        $this->loadProtectionFields($threat_id);

        return [
            'rmsd' => $this->rmsd,
            'threat' => $this->threat,
            'asset' => $this->asset,
            'assetID' => $id,
            'valuation' => $this->valuation,
            ...array_combine($this->fields, array_map(fn($field) => $this->$field, $this->fields)),
        ];
    }

    /**
     * Load related models
     *
     * @param int|null $id
     * @param int|null $threat_id
     */
    private function loadModels(?int $id, ?int $threat_id): void
    {
        $this->asset = $id ? AssetManagement::find($id) : null;
        $this->threat = Threat::find($threat_id);
        $this->rmsd = RMSDModel::where('threat_id', $threat_id)->get();
        $this->valuation = Valuation::where('asset_id', $id)->get();
    }

    /**
     * Load protection fields
     *
     * @param int|null $threat_id
     */
    private function loadProtectionFields(?int $threat_id): void
    {
        $this->protection = ProtectionModel::where('threat_id', $threat_id)->first();
        $this->decision = $this->protection?->decision;

        foreach ($this->fields as $field) {
            $this->$field = $this->protection?->$field ?? null;
        }
    }

    public function name(): ?string
    {
        return 'Step 5: Protection Strategy and Decision';
    }

    public function description(): ?string
    {
        return 'Define and implement strategies to protect assets from identified threats, ensuring the continuity of operations and minimizing potential damages.';
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
            Layout::accordion([
                'Protection Information' => $this->getProtectionInformationLayout(),
            ]),
            ...$this->getModalLayouts(),
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
            Group::make([
                $this->createSafeguardLabel(),
                $this->createRiskLevelLabel(),
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

    private function createSafeguardLabel(): object
    {
        return Label::make('current')
            ->title('Safeguard ID:')
            ->value(optional($this->rmsd?->first())->safeguard_id);
    }

    private function createRiskLevelLabel(): object
    {
        return Label::make('risk_level')
            ->title('Risk Level: ')
            ->value(optional($this->rmsd?->first())->risk_level);
    }

    private function getProtectionInformationLayout(): array
    {
        return [
            ProtectionListener::class,
        ];
    }

    private function createProtectionStrategyLabel(): object
    {
        return Label::make('current')
            ->title('Current Protection Strategy:')
            ->value(optional($this->protection?->first())->protection_strategy)
            ->canSee((bool)optional($this->protection?->first())->protection_strategy);
    }

    private function createProtectionIdLabel(): object
    {
        return Label::make('current')
            ->title('Current Protection ID:')
            ->value(optional($this->protection?->first())->protection_id)
            ->canSee((bool)optional($this->protection?->first())->protection_id);
    }

    private function hasProtectionData(): bool
    {
        $protection = $this->protection?->first();
        return (bool)($protection?->protection_type ||
            $protection?->protection_strategy ||
            $protection?->protection_id);
    }

    private function getModalLayouts(): array
    {
        return [
            Layout::modal('chooseThreat', AllSelectionListener::class)
                ->title($this->getThreatModalTitle()),
            Layout::modal('chooseAssetAndThreat', AllSelectionListener::class)
                ->title($this->getThreatModalTitle()),
            Layout::modal('assetModal', AssetSelectionListener::class)
                ->title('Change Asset'),
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
            $protection = ProtectionModel::updateOrCreate(
                ['threat_id' => $this->threat->id],
                $this->getProtectionData($request)
            );

            Log::info('Protection Strategy and Decision updated successfully.', ['protection' => $protection]);
            Toast::info('Protection Strategy and Decision saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving Protection Strategy:', ['error' => $e->getMessage()]);
            Toast::error('Error saving Protection Strategy: ' . $e->getMessage());
        }
    }

    private function getProtectionData(Request $request): array
    {
        $data = [];
        foreach ($this->fields as $field) {
            $data[$field] = $request->input($field) ?? optional($this->protection?->first())->$field ?? null;
        }
        return $data;
    }

    public function next(Request $request)
    {
        return redirect()->route('platform.assessment.treatment', [
            'id' => $request->id,
            'threat_id' => $this->threat->id,
        ]);
    }

    public function changeThreat(Request $request)
    {
        try {
            $threatID = $request->input('threat.name');
            $assetID = $threatID ? Threat::find($threatID)?->asset_id : null;

            Toast::info('Threat changed.');
            return redirect()->route('platform.assessment.protection', [
                'id' => $assetID,
                'threat_id' => $threatID,
            ]);
        } catch (\Exception $e) {
            Log::error('Error changing threat:', ['error' => $e->getMessage()]);
            Toast::error('Threat not found.');
            return redirect()->back();
        }
    }

    public function changeAsset(Request $request)
    {
        try {
            $asset = AssetManagement::find($request->input('asset_name'));
            
            if ($asset) {
                return redirect()->route('platform.assessment.protection', ['id' => $asset->id]);
            }
            
            Toast::error('No asset found for the selected asset.');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Error changing asset:', ['error' => $e->getMessage()]);
            Toast::error('Error changing asset: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function changeAssetAndThreat(Request $request)
    {
        try {
            $asset = AssetManagement::find($request->input('asset_name'));
            $threat = Threat::find($request->input('threat_name'));

            if ($asset && $threat) {
                return redirect()->route('platform.assessment.protection', [
                    'id' => $asset->id,
                    'threat_id' => $threat->id,
                ]);
            }
            
            Toast::error('No threat found for the selected asset.');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Error changing asset and threat:', ['error' => $e->getMessage()]);
            Toast::error('Error changing asset and threat: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
