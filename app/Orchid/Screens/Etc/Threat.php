<?php

namespace App\Orchid\Screens\Assessment;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Log;
use App\Models\Assessment\Treatment;
use App\Models\Assessment\Protection;
use Orchid\Screen\Actions\ModalToggle;
use App\Orchid\Layouts\Assessment\ThreatLayout;
use App\Orchid\Layouts\Listener\ThreatListener;
use App\Models\Assessment\Threat as ThreatModel;
use App\Orchid\Layouts\Listener\AssetSelectionListener;
use App\Models\Management\AssetManagement;
use Illuminate\Http\RedirectResponse;

class Threat extends Screen
{
    /** @var AssetManagement|null */
    public $asset;

    /** @var ThreatModel|null */
    public $asset_threat;

    /** @var ThreatModel|null */
    public $threat;

    /** @var array */
    protected const REQUIRED_RMSD_FIELDS = [
        'safeguard_id', 'safeguard_group', 'risk_level', 'risk_owner',
        'vuln_group', 'vuln_name', 'business_loss', 'impact_level', 'likelihood'
    ];

    /** @var array */
    protected const REQUIRED_TREATMENT_FIELDS = [
        'start_date', 'end_date', 'personnel', 'residual_risk'
    ];

    /** @var array */
    protected const REQUIRED_PROTECTION_FIELDS = [
        'protection_strategy', 'protection_id', 'decision'
    ];

    public function query(int $id = null, int $threat_id = null): array
    {
        if (is_null($id)) {
            return $this->getDefaultQueryResponse();
        }

        return $this->loadData($id, $threat_id);
    }

    private function getDefaultQueryResponse(): array
    {
        return [
            'threat' => null,
            'asset' => null,
            'asset_threat' => null,
            'threat_table' => [],
            'message' => 'No asset selected. Please select an asset.',
        ];
    }

    private function loadData(int $id, ?int $threat_id): array
    {
        $this->asset = AssetManagement::findOrFail($id);
        $this->asset_threat = $threat_id ? ThreatModel::find($threat_id) : null;
        $this->threat = $this->asset_threat;

        return [
            'asset' => $this->asset,
            'asset_threat' => $this->asset_threat,
            'threat_table' => ThreatModel::where('asset_id', $id)->get(),
            'threat' => $this->threat,
        ];
    }

    public function name(): ?string
    {
        return 'Step 2: Threat Classification';
    }

    public function description(): ?string
    {
        return "Threat Classification is the process of categorizing potential security risks based on their nature, severity, and impact on an organization's infrastructure. It involves identifying various types of threats, such as cyberattacks, data breaches, physical security risks, and internal vulnerabilities.";
    }

    public function commandBar(): array
    {
        return [
            Button::make($this->asset_threat ? __('Save Threat') : __('Add Threat'))
                ->icon($this->asset_threat ? 'bs.save' : 'bs.plus')
                ->method('createOrUpdate')
                ->parameters([
                    'id' => $this->asset?->id,
                    'threat_id' => $this->asset_threat?->id,
                ]),
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
            ThreatListener::class,
            ThreatLayout::class,
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

    public function markAsDraft(Request $request, int $threat_id): RedirectResponse
    {
        $threat = ThreatModel::findOrFail($threat_id);
        $threat->update(['status' => 'Draft']);

        Toast::info('Risk Treatment Plan marked as draft.');
        return redirect()->route('platform.assessment.threat', ['id' => $request->id]);
    }

    public function markAsDone(Request $request, int $threat_id): ?RedirectResponse
    {
        try {
            $threat = ThreatModel::findOrFail($threat_id);
            
            if (!$this->validateRequiredModels($threat)) {
                return null;
            }

            $threat->update(['status' => 'Completed']);
            Toast::info('Risk Treatment Plan marked as done.');
            return redirect()->route('platform.assessment.threat', ['id' => $request->id]);

        } catch (\Exception $e) {
            Log::error('Error marking threat as done:', ['error' => $e->getMessage()]);
            Toast::error('An error occurred: ' . $e->getMessage());
            return null;
        }
    }

    private function validateRequiredModels(ThreatModel $threat): bool
    {
        $rmsd = RMSD::where('threat_id', $threat->id)->first();
        $treatment = Treatment::where('threat_id', $threat->id)->first();
        $protection = Protection::where('threat_id', $threat->id)->first();

        if (!$rmsd || !$treatment || !$protection) {
            Toast::error('Please ensure all RMSD, Treatment, and Protection details are filled.');
            return false;
        }

        if (!$this->validateRMSDFields($rmsd)) {
            Toast::error('Please ensure all RMSD fields are filled.');
            return false;
        }

        if (!$this->validateTreatmentFields($treatment)) {
            Toast::error('Please ensure all Treatment fields are filled.');
            return false;
        }

        if (!$this->validateProtectionFields($protection)) {
            Toast::error('Please ensure all Protection fields are filled.');
            return false;
        }

        return true;
    }

    private function validateRMSDFields(RMSD $rmsd): bool
    {
        return collect(self::REQUIRED_RMSD_FIELDS)->every(fn($field) => !empty($rmsd->$field));
    }

    private function validateTreatmentFields(Treatment $treatment): bool
    {
        return collect(self::REQUIRED_TREATMENT_FIELDS)->every(fn($field) => !empty($treatment->$field));
    }

    private function validateProtectionFields(Protection $protection): bool
    {
        return collect(self::REQUIRED_PROTECTION_FIELDS)->every(fn($field) => !empty($protection->$field));
    }

    public function createOrUpdate(Request $request, ?int $id = null): RedirectResponse
    {
        $request->validate([
            'threat_name' => 'required|string|max:255|unique:asset_threat,threat_name,' . $id,
            'threat_group' => 'required|string|max:255',
        ]);

        try {
            $threat = $this->asset_threat ?? new ThreatModel();
            $threat->fill([
                'asset_id' => $this->asset?->id,
                'threat_name' => $request->threat_name,
                'threat_group' => $request->threat_group,
                'status' => 'Draft'
            ]);
            $threat->save();

            Toast::info('Threat details saved successfully.');
            return redirect()->route('platform.assessment.threat', ['id' => $this->asset?->id]);

        } catch (\Exception $e) {
            Log::error('Error saving threat:', ['error' => $e->getMessage()]);
            Toast::error('Failed to save threat: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function changeAsset(Request $request): RedirectResponse
    {
        try {
            $asset = AssetManagement::findOrFail($request->input('asset_name'));
            return redirect()->route('platform.assessment.threat', ['id' => $asset->id]);
        } catch (\Exception $e) {
            Log::error('Error changing asset:', ['error' => $e->getMessage()]);
            Toast::error('Error changing asset: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function remove(Request $request): void
    {
        try {
            $threat = ThreatModel::findOrFail($request->get('id'));
            $this->deleteRelatedModels($threat);
            $threat->delete();
            
            Toast::info('Threat and related data deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting threat:', ['error' => $e->getMessage()]);
            Toast::error('Failed to delete threat.');
        }
    }

    private function deleteRelatedModels(ThreatModel $threat): void
    {
        RMSD::where('threat_id', $threat->id)->delete();
        Protection::where('threat_id', $threat->id)->delete();
        Treatment::where('threat_id', $threat->id)->delete();
    }
}