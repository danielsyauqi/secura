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
use App\Models\Management\AssetManagement; // Assuming you have an Asset model

class Valuation extends Screen
{
    public $asset;   
    public $asset_valuation;
    public $confidential;
    public $integrity;
    public $availability;
    public $asset_value;

    public $confidential_5;
    public $integrity_5;
    public $availability_5;
    public $asset_value_5;

    public function query($id = null): iterable
    {
        $this->asset = AssetManagement::find($id);
        $this->asset_valuation = ValuationModel::where('asset_id', $id)->get();

        $this->confidential = optional($this->asset_valuation->first())->confidential ?? null;
        $this->integrity = optional($this->asset_valuation->first())->integrity ?? null;
        $this->availability = optional($this->asset_valuation->first())->availability ?? null;
        $this->asset_value = optional($this->asset_valuation->first())->asset_value ?? null;


        $scale_5 = json_decode(optional($this->asset_valuation->first())->scale_5, true) ?? [];
        $this->confidential_5 = $scale_5['confidential'] ?? null;
        $this->integrity_5 = $scale_5['integrity'] ?? null;
        $this->availability_5 = $scale_5['availability'] ?? null;
        $this->asset_value_5 = $scale_5['asset_value'] ?? null;

        Log::info('Scale 5 values:', [
            'confidential_5' => $this->confidential_5,
            'integrity_5' => $this->integrity_5,
            'availability_5' => $this->availability_5,
            'asset_value_5' => $this->asset_value_5,
        ]);



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
            'confidential_5' => $this->confidential_5,
            'integrity_5' => $this->integrity_5,
            'availability_5' => $this->availability_5,
            'asset_value_5' => $this->asset_value_5,

        ];
    }

    public function name(): ?string
    {
        return 'Step 1: Valuation of Asset';
    }

    public function description(): ?string
    {
        return 'The valuation of an asset is a crucial initial step in the overall assessment process. This step involves determining the monetary value or worth of the asset. Accurate valuation is essential as it forms the basis for further analysis and decision-making regarding the asset. The valuation process may involve various methods and techniques depending on the type of asset and the context in which the valuation is being performed.';
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
            
            Layout::accordion([
                "Asset Dependency" => Layout::rows([
                    Group::make([
                        Input::make("depend_on")
                        ->title('Asset Depend On')
                        ->value(optional($this->asset_valuation->first())->depend_on),

                        Input::make("depended_asset")
                        ->title('Depended Asset')
                        ->value(optional($this->asset_valuation->first())->depended_asset),
                    ]),
                ]),
            ]),         

            ValuationListener::class,
           
        ];
    }

    public function save(Request $request)
    {

        try {

            $flag=0;

            $json = json_encode([
                'confidential' => $request->input('confidential_5'),
                'integrity' => $request->input('integrity_5'),
                'availability' => $request->input('availability_5'),
                'asset_value' => $request->input('asset_value_5'),
            ]);
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
                    'scale_5' => $json ?? $this->asset_valuation->first()->scale_5,
                ]
            );

            if($request->input('asset_value' ) !== $this->asset_valuation->first()->asset_value && $this->asset_valuation->first()->asset_value !== null){
                RMSD::whereHas('threat', function ($query) {
                    $query->where('asset_id', $this->asset->id);
                })
                ->update(['impact_level' => null, 'risk_level' => null , 'business_loss' => null, 'likelihood' => null]);


                $flag=1;    

            }

            if($request->input('asset_value_5') !== $this->asset_value_5 && $this->asset_value_5 !== null){
                RMSD::whereHas('threat', function ($query) {
                    $query->where('asset_id', $this->asset->id);
                })
                ->update(['scale_5' => ['impact_level' => null , 'risk_level' => null , 'business_loss' => null, 'likelihood' => null ]]);

                
                $flag=2;    
            }

            if($flag === 1){
                Toast::info('Impact Level (Scale 3) has been reset in RMSD due to changes in Asset Value.');
                Threat::where('asset_id', $this->asset->id)->update(['status' => 'Draft']);

            }else if($flag === 2){
                Toast::info('Impact Level (Scale 3) and Impact Level (Scale 5) has been reset in RMSD due to changes in Asset Value.');
                Threat::where('asset_id', $this->asset->id)->update(['status' => 'Draft']);

            }else{
                Toast::info('Asset valuation saved successfully.');
            }



                   

        } catch (\Exception $e) {
            Toast::error('An error occurred while saving the asset valuation: ' . $e->getMessage());        
        }
    }

    public function next(){
        return redirect()->route('platform.assessment.threat', [
            'id' => $this->asset->id,
        ]);
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
                Toast::error('No asset found for the selected asset.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // Handle error if anything goes wrong
            Toast::error('An error occurred while changing the asset: ' . $e->getMessage());
            return redirect()->back();
        }
    }

}