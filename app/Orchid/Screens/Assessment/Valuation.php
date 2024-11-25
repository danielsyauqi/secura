<?php

namespace App\Orchid\Screens\Assessment;

use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Range;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\RadioButtons;
use App\Orchid\Layouts\Listener\ValuationListener;
use App\Models\Assessment\Valuation as ValuationModel;
use App\Orchid\Layouts\Listener\AssetSelectionListener;
use App\Models\Management\AssetManagement; // Assuming you have an Asset model

class Valuation extends Screen
{
    public $asset;   
    public $asset_valuation;
    public $confidential;
    public $integrity;
    public $availability;
    public $asset_value;

    public function query($id): iterable
    {
        $this->asset = AssetManagement::find($id);
        $this->asset_valuation = ValuationModel::where('asset_id', $id)->get();

        $this->confidential = optional($this->asset_valuation->first())->confidential;
        $this->integrity = optional($this->asset_valuation->first())->integrity;
        $this->availability = optional($this->asset_valuation->first())->availability;
        $this->asset_value = optional($this->asset_valuation->first())->asset_value;


        if (!$this->asset) {
            // Optionally, you can set a default value or return an empty array
            Toast::warning('No asset selected. You can create a new valuation or select an asset.');
        }
        return [
            'asset_valuation' => $this->asset_valuation,
            'asset' => $this->asset,

            
            'confidential' => $this->confidential,
            'integrity' => $this->integrity,
            'availability' => $this->availability,
            'asset_value' => $this->asset_value,

        ];
    }

    public function name(): ?string
    {
        return 'Step 1: Valuation of Asset';
    }

    public function description(): ?string
    {
        return 'Include professionals with expertise in security, ICT, and the organization’s core business operations. 
                Team members should understand the technical and operational aspects of your organization to handle security and risk data effectively.';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Next Step'))
                ->icon('bs.arrow-bar-right')
                ->method('save'),
        ];
    }

    public function layout(): array
    {

        

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

                
            ])->title('Asset Details'),

            Layout::modal('assetModal', AssetSelectionListener::class, )->title('Change Threat'),
                
            Layout::rows([
                Group::make([
                    Input::make("depend_on")
                    ->title('Asset Depend On')
                    ->value(optional($this->asset_valuation->first())->depend_on),

                    Input::make("depended_asset")
                    ->title('Depended Asset')
                    ->value(optional($this->asset_valuation->first())->depended_asset),
                ]),
            ]),
            

            ValuationListener::class,
           
        ];
    }

    public function save(Request $request)
    {

        try {
            // Directly pass values using null coalescing operator in the updateOrCreate method
            ValuationModel::updateOrCreate(
                ['asset_id' => $this->asset->id], // Use threat_id from the current threat (from headers or query)
                [
                    'depend_on' => $request->input('depend_on') ?? $this->asset_valuation->first()->depend_on,
                    'depended_asset' => $request->input('depended_asset') ?? $this->asset_valuation->first()->depended_asset,
                    'confidential' => $request->input('confidential') ?? $this->asset_valuation->first()->confidential,
                    'integrity' => $request->input('integrity') ?? $this->asset_valuation->first()->integrity,
                    'availability'  => $request->input('availability') ?? $this->asset_valuation->first()->safeguard_group,
                    'asset_value'  => $request->input('asset_value' ) ?? $this->asset_valuation->first()->asset_value,
                ]
            );

            Toast::info('Asset valuation saved successfully.');
            return redirect()->route('platform.assessment.threat', [$this->asset->id]);
           

        } catch (\Exception $e) {
            Toast::error('An error occurred while saving the asset valuation: ' . $e->getMessage());        
        }
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
                return redirect()->route('platform.assessment.valuation', [
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

}