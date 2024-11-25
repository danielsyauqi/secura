<?php

namespace App\Orchid\Screens\Assessment;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\Risk;
use App\Models\Assessment\RMSD;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use App\Models\Assessment\Impact;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Models\Assessment\Safeguard;
use App\Models\Assessment\Likelihood;
use App\Models\Assessment\Vulnerable;
use Orchid\Screen\Actions\ModalToggle;
use App\Orchid\Layouts\Assessment\ThreatLayout;
use App\Orchid\Layouts\Listener\ThreatListener;
use App\Models\Assessment\Threat as ThreatModel;
use App\Orchid\Layouts\Assessment\ThreatGroupOptions;
use App\Orchid\Layouts\Listener\AssetSelectionListener;
use App\Models\Management\AssetManagement; // Assuming you have an Asset model

class Threat extends Screen
{
    public $asset;
    public $asset_threat;

    public function query(int $id, int $threat_id = null): iterable
    {
        $this->asset = AssetManagement::findOrFail($id);
        $this->asset_threat = $threat_id ? ThreatModel::where('asset_id', $id)->where('id', $threat_id)->first() : new ThreatModel();

        return [
            'asset' => $this->asset,
            'asset_threat' => $this->asset_threat,
            'threat_table' => ThreatModel::where('asset_id', $id)->get(),
        ];
    }



    public function name(): ?string
    {
        return 'Step 2: Threat of Asset';
    }

    public function description(): ?string
    {
        return 'Include professionals with expertise in security, ICT, and the organization’s core business operations. 
                Team members should understand the technical and operational aspects of your organization to handle security and risk data effectively.';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make($this->asset_threat->exists ? __('Save Threat') : __('Add Threat'))
                ->icon($this->asset_threat->exists ? 'bs.save' : 'bs.plus')
                ->method('createOrUpdate')
                ->parameters([
                    'id' => $this->asset->id,
                    'threat_id' => $this->threat->id ?? null,
                ]),
        ];
    }


    public function layout(): array
    {


        // Map through `asset_threat` and create field

        return [
            Layout::rows([
                Group::make([
                    Input::make('asset.name')
                        ->title('Asset Name')
                        ->value(value: optional(value: $this->asset)->type)
                        ->readonly(),

                    Input::make('asset.type')
                        ->title('Asset Type')
                        ->value(value: optional(value: $this->asset)->type)
                        ->readonly(),
                ]),

                ModalToggle::make('Change Asset')
                    ->modal('assetModal')
                    ->method('changeAsset')
                    ->icon('bs.box-arrow-up-right'),

                
            ]),

            Layout::modal('assetModal', AssetSelectionListener::class, )->title('Change Threat'),

            // Add threat fields with empty default values
            ThreatListener::class,

            // Include ThreatLayout if needed
            ThreatLayout::class,
        ];
    }



    public function save(): void
    {
        try {
            // Update each asset threat record
            foreach ($this->asset_threat as $threat) {
                ThreatModel::updateOrCreate(
                    ['id' => $threat->asset_id],
                    [
                        'asset_id' => $this->asset->id,
                        'threat_group' => request("threat_group"),
                        'threat_name' => request("threat_name"),
                    ]
                );
            }
            
            RMSD::create([
                'threat_id' => $threat->id,
            ]);

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
            }

            // Delete the asset
            $threat->delete();
            
            Toast::info('Asset and its related data deleted successfully.');
        } else {
            Toast::error('Failed to delete asset.');
        }
    }

    public function createOrUpdate(Request $request, int $id = null, int $threat_id = null)
    {
        $threat = $threat_id ? ThreatModel::findOrFail($threat_id) : new ThreatModel();

        try {
            // Update or create the threat with asset_id and threat details only
            $threat->asset_id = $id; // Associate the threat with the asset
            $threat->fill($request->only(['threat_name', 'threat_group'])); // Fill only threat details
            $threat->save();

            Toast::info('Threat details saved successfully.');

            // Redirect back to the asset's main page with the correct asset_id
            return redirect()->route('platform.assessment.threat', ['id' => $id]);

        } catch (\Exception $e) {
            Toast::error('Failed to save threat details: ' . $e->getMessage());
        }
    }



}