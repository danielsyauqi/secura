<?php

namespace App\Orchid\Screens\Assessment;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
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
use App\Models\Management\AssetManagement; // Assuming you have an Asset model

class Threat extends Screen
{
    public $asset;
    public $asset_threat;
    public $threat;

    public function query(int $id = null, int $threat_id = null): iterable
    {

        if (is_null($id)) {
            // Handle the case where $id is null
            return [
                'threat' => null,
                'asset' => null,
                'asset_threat' => null,
                'threat_table' => [],
                'message' => 'No asset selected. Please select an asset.',
            ];
        }

        $this->asset = AssetManagement::findOrFail($id) ?? null;
        $this->asset_threat = $threat_id ?? null;
        $this->threat = ThreatModel::find($threat_id) ?? null;

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
        return "Threat Classification is the process of categorizing potential security risks based on their nature, severity, and impact on an organization's infrastructure. It involves identifying various types of threats, such as cyberattacks, data breaches, physical security risks, and internal vulnerabilities. These threats are typically classified into categories, allowing for a better understanding of their potential impact and helping to prioritize response efforts. The classification system aids in determining the appropriate level of urgency, resource allocation, and mitigation strategies, ensuring that organizations can proactively address security risks and safeguard their assets and sensitive information.";
    }

    public function commandBar(): iterable
    {
        return [
            Button::make($this->asset_threat ? __('Save Threat') : __('Add Threat'))
                ->icon($this->asset_threat ? 'bs.save' : 'bs.plus')
                ->method('createOrUpdate')
                ->parameters([
                    'id' => $this->asset->id ?? null,
                    'threat_id' => $this->asset_threat->id ?? null,
                ]),
        ];
    }


    public function layout(): array
    {


        // Map through `asset_threat` and create field

        return [
            Layout::accordionShow([
                'Asset Information' => Layout::rows([
                    Group::make([
                        Input::make('asset.name')
                            ->title('Asset Name')
                            ->style('color: #43494f;')
                            ->value(value: optional(value: $this->asset)->type)
                            ->readonly(),
    
                        Input::make('asset.type')
                            ->title('Asset Type')
                            ->style('color: #43494f;')
                            ->value(value: optional(value: $this->asset)->type)
                            ->readonly(),
                    ]),
    
                    ModalToggle::make(!$this->asset ? __('Choose Asset') : __('Change Asset'))
                    ->modal('chooseAsset')
                    ->icon('bs.box-arrow-up-right')
                    ->method('changeAsset')
                    ->open(!$this->asset)
    
                    
                ]),
            ]),
            
            Layout::modal('chooseAsset', AssetSelectionListener::class,)->title(!$this->asset ? __('Choose Asset') : __('Change Asset')),

            Layout::rows([
                Group::make([
                    Label::make('current')
                        ->title('Current Threat Group:')
                        ->value(optional($this->threat ? $this->threat: null)->threat_group)
                        ->canSee((bool) optional($this->threat ? $this->threat: null)->threat_group),

                    Label::make('current')
                        ->title('Current Threat Name:')
                        ->value(optional($this->threat ? $this->threat: null)->threat_name)
                        ->canSee((bool) optional($this->threat ? $this->threat: null)->threat_name),
                ]),
            ])->canSee(
                (bool) (optional($this->threat ? $this->threat: null)->threat_group &&
                optional($this->threat ? $this->threat: null)->threat_name
            )),

            // Add threat fields with empty default values
            ThreatListener::class,

            // Include ThreatLayout if needed
            ThreatLayout::class,
        ];
    }

    public function markAsDraft(Request $request, $threat_id){

            $threat = ThreatModel::where('id', $threat_id)->first() ?? null;
            $threat->update(['status' => 'Draft']);

            Toast::info('Risk Treatment Plan marked as draft.');
            return redirect()->route('platform.assessment.threat', ['id' => $request->id]);

    }

    public function markAsDone(Request $request, $threat_id)
    {
    try {

        // Check if all fields in RMSD, Treatment, and Protection are filled
        $threat = ThreatModel::where('id', $threat_id)->first() ?? null;
        $rmsd = RMSD::where('threat_id', $threat->id)->first() ?? null;
        $treatment = Treatment::where('threat_id', $threat->id)->first() ?? null;
        $protection = Protection::where('threat_id', $threat->id)->first() ?? null;

        // Check if all necessary details are filled
        if (!$rmsd || !$treatment || !$protection) {
        Toast::error('Please ensure all RMSD, Treatment, and Protection details are filled.');

        return;
        }

        if (!$rmsd || !$rmsd->safeguard_id || !$rmsd->safeguard_group || !$rmsd->risk_level
        || !$rmsd->risk_owner || !$rmsd->vuln_group || !$rmsd->vuln_name || !$rmsd->business_loss
        || !$rmsd->impact_level || !$rmsd->likelihood) {
            Toast::error('Please ensure all RMSD fields are filled.');
            return;
        }

        if (!$treatment || !$treatment->start_date || !$treatment->end_date || !$treatment->personnel || !$treatment->residual_risk) {
            Toast::error('Please ensure all Treatment fields are filled.');
            return;
        }

        if (!$protection || !$protection->protection_strategy || !$protection->protection_id || !$protection->decision) {
            Toast::error('Please ensure all Protection fields are saved / filled.');
            return;
        }

        // Assuming you want to perform some finalization logic here
        // For example, marking the treatment plan as completed
        if($rmsd && $treatment && $protection){
            $threat->update(['status' => 'Completed']);
        }

        Toast::info('Risk Treatment Plan marked as done.');
        return redirect()->route('platform.assessment.threat', ['id' => $request->id]);

    } catch (\Exception $e) {
        Toast::error('An error occurred while marking the Risk Treatment Plan as done, details: ' . $e->getMessage());
    }
    }

    public function save(Request $request, $id): void
    {
        $request->validate([
            'threat_name' => 'required|string|max:255|unique:asset_threat,threat_name,' . $id,
            'threat_group' => 'required|string|max:255',
            
        ]);
        try {
            // Update each asset threat record
            if (is_iterable($this->asset_threat)) {
                foreach ($this->asset_threat as $threat) {
                    $log = ThreatModel::updateOrCreate(
                        ['id' => $threat->asset_id],
                        [
                            'asset_id' => $this->asset->id,
                            'threat_group' => request("threat_group"),
                            'threat_name' => request("threat_name"),
                            'status' => 'Draft',
                        ]
                    );

                    RMSD::create([
                        'threat_id' => $threat->id,
                    ]);
                }
            }


            Toast::info('Asset threat saved successfully.');
        } catch (\Exception $e) {
            Toast::error('An error occurred while saving the asset threat: ' . $e->getMessage());
        }
    // Create a new rmsd model entry
    
    }

    public function changeAsset(Request $request)
    {
        // Get the selected asset name (asset_id)
        $assetID = $request->input('asset_name');
        
        try {
            // Fetch the asset and its associated threat
            $asset = AssetManagement::find($assetID);
    
            if ($asset) {
                // Set the threat name dynamically based on the selected asset
                return redirect()->route('platform.assessment.threat', [
                    'id' => $asset->id,
                ]);
            } else {
                Toast::error('No threat found for the selected asset.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // Handle error if anything goes wrong
            Toast::error('An error occurred while changing the asset: ' . $e->getMessage());
            return redirect()->back();
        }
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

    public function createOrUpdate(Request $request, $id)
    {

        $request->validate([
            'threat_name' => 'required|string|max:255|unique:asset_threat,threat_name,' . $id,
            'threat_group' => 'required|string|max:255',
            
        ]);
        
        $threat = $this->asset_threat ? ThreatModel::findOrFail($this->asset_threat) : new ThreatModel();

        try {

            
            // Update or create the threat with asset_id and threat details only
            $threat->asset_id = $this->asset ? $this->asset->id : null; // Associate the threat with the asset
            $threat->fill(array_merge($request->only(['threat_name', 'threat_group']), ['status' => 'Draft'])); // Fill only threat details
            $threat->save();
            

            Toast::info('Threat details saved successfully.');

            // Redirect back to the asset's main page with the correct asset_id
            return redirect()->route('platform.assessment.threat', ['id' => $this->asset ? $this->asset->id : null]);

        } catch (\Exception $e) {
            Toast::error('Failed to save threat details: ' . $e->getMessage());
        }
    }



}