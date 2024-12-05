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
use Orchid\Screen\Fields\RadioButtons;
use App\Models\Management\AssetManagement;
use App\Models\Assessment\RMSD as RMSDModel;
use App\Orchid\Layouts\Listener\AllSelectionListener;
use App\Orchid\Layouts\Listener\AssetSelectionListener;
use App\Orchid\Layouts\Listener\RiskCalculationListener;
use App\Orchid\Layouts\Listener\ThreatSelectionListener;

class RiskCalculation extends Screen
{
    public $threat;
    public $asset;
    public $rmsd;
    public $assetID;
    public $risk_level;
    public $likelihood;
    public $impactLevel;
    public $risk_owner;

    public $impact_level_5;
    public $likelihood_5;
    public $risk_level_5;

    public function query($id = null,$threat_id = null): iterable
    {

        if (is_null($threat_id)) {
            Toast::warning('No threat selected. You can create or select a new threat.');


            return [
                'threat' => null,
                'rmsd' => null,
                'risk_level' => null,
                'risk_owner' => null,
                'asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
                'assetID' => $id,
            ];


        } else if (is_null($threat_id) && is_null($id)) {
            Toast::warning('No threat and asset selected. You can create or select a new asset and threat.');

            return [
                'asset' => null,
                'assetID' => null,
                'threat' => null,
                'rmsd' => null,
                'risk_level' => null,
                'risk_owner' => null,

            ];


        } else{

            $threat_scale_5 = json_decode(RMSDModel::where('threat_id', $threat_id)->first()->scale_5 ?? '[]', true);
            $this->impact_level_5 = $threat_scale_5['impact_level'] ?? null;
            $this->likelihood_5 = $threat_scale_5['likelihood'] ?? null;
            $this->risk_level_5 = $threat_scale_5['risk_level'] ?? null;



            return [
                'rmsd' => RMSDModel::where('threat_id', $threat_id)->get(),
                'threat' => Threat::find($threat_id),
                'asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
                'assetID' => $id,

                'likelihood_5' => $this->likelihood_5,
                'impact_level_5' => $this->impact_level_5,
                'risk_level_5' => $this->risk_level_5,
                
                'impact_level' => optional(RMSDModel::where('threat_id', $threat_id)->first())->impact_level ?? null,
                'likelihood' => optional(RMSDModel::where('threat_id', $threat_id)->first())->likelihood ?? null,
    
                'risk_level' => optional(RMSDModel::where('threat_id', $threat_id)->first())->risk_level ?? null,
                'risk_owner' => optional(RMSDModel::where('threat_id', $threat_id)->first())->risk_owner ?? null,
                
            ];
        }


        
    }
    



    public function name(): ?string
    {
        return 'Step 4: Risk Calculation';
    }

    public function description(): ?string
    {
        return 'Include professionals with expertise in security, ICT, and the organization’s core business operations.';
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

        /** @var TYPE_NAME $this */
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

                    ModalToggle::make('Change Asset')
                        ->modal('assetModal')
                        ->method('changeAsset')
                        ->icon('bs.box-arrow-up-right'),
                ]),

                'Threat Information' =>  Layout::rows([
                    Group::make([
                        Input::make('threat.name')
                                ->title('Current Threat')
                                ->style('color: #43494f;')
                                ->value(optional($this->threat)->threat_name)
                                ->readonly(),
    
                        Input::make('threat.group')
                            ->title('Threat Group')
                            ->style('color: #43494f;')
                            ->value(optional($this->threat)->threat_group)
                            ->readonly(),
                    ]),
                    ModalToggle::make(
                        !$this->threat
                            ? (!$this->asset ? __('Choose Asset and Threat') : __('Choose Threat'))
                            : __('Change Threat')
                    )->icon('bs.box-arrow-up-right')

                    ->modal(!$this->threat && !$this->asset ? 'chooseAssetAndThreat' : 'chooseThreat')
                    ->method(!$this->threat && !$this->asset ? 'changeAssetAndThreat' : 'changeThreat')
                    ->open(!$this->threat),
                ]),


            ]),

            Layout::modal('assetModal', AssetSelectionListener::class, )->title('Change Asset'),

            Layout::modal(
                'chooseThreat',
                AllSelectionListener::class
            )->title(
                !$this->threat
                    ? (!$this->asset 
                        ? __('Choose Asset and Threat') // Both threat and asset are missing
                        : __('Choose Threat')) // Only threat is missing
                    : __('Change Threat') // Threat exists
            ),

           

            RiskCalculationListener::class,







        ];
    }


    public function save(Request $request)
    {
        try {
            Log::info('Request data:', $request->all()); // Log the request data

            $threatId = $this->threat->id;
            $rmsd = RMSDModel::updateOrCreate(
                ['threat_id' => $threatId],
                [
                    'likelihood' => $request->input('likelihood') ?? $this->rmsd->first()->likelihood ?? null,
                    'risk_level' => $request->input('risk_level') ?? $this->rmsd->first()->risk_level ?? null,
                    'risk_owner' => $request->input('risk_owner') ?? $this->rmsd->first()->risk_owner ?? null,
                ]
            );

            $scale_5 = json_decode($rmsd->scale_5 ?? '[]', true);
            $scale_5['likelihood'] = $request->input('likelihood_5') ?? $this->likelihood_5 ?? $scale_5['likelihood'] ?? null;
            $scale_5['risk_level'] = $request->input('risk_level_5') ?? $this->risk_level_5 ?? $scale_5['risk_level'] ?? null;

            $rmsd->update(['scale_5' => json_encode($scale_5)]);



            Toast::info('Risk Calculation saved successfully.');
        } catch (\Exception $e) {
            Toast::error('An error occurred while saving the Risk Calculation, details: ' . $e->getMessage());
        }
    }

    public function next(Request $request)
    {
        return redirect()->route('platform.assessment.protection', [
            'id' => $request->id,
            'threat_id' => $this->threat->id,
        ]);
    }


    
    public function changeThreat(Request $request)
    {
        $threatID = $request->input('threat.name');
        $assetID = $threatID ? Threat::find($threatID)->asset_id : null;

        try{
            Toast::info('Threat changed.');
            // Redirect to the desired route with the threat's id
            return redirect()->route('platform.assessment.risk', [
                'id' => $assetID,       // This is the ID of the selected threat
                'threat_id' => $threatID, // This will be passed as a parameter
            ]);


        } catch (\Exception $e) {
            // Handle the case where the threat is not found
            Toast::error('Threat not found.');
            return redirect()->back(); // Redirect back if the threat is not found
        }
    }

    public function changeAssetAndThreat(Request $request){
        $assetID = $request->input('asset_name');
        $threatID = $request->input('threat_name');

        try {
            // Fetch the asset and its associated threat
            $asset = AssetManagement::find($assetID);
            $threat = Threat::find($threatID);

            if ($asset && $threat) {
                // Set the threat name dynamically based on the selected asset
                return redirect()->route('platform.assessment.risk', [
                    'id' => $asset->id,
                    'threat_id' => $threat->id ?? null,
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

    
    public function changeAsset(Request $request)
    {
        // Get the selected asset name (asset_id)
        $assetID = $request->input('asset_name');
        
        try {
            // Fetch the asset and its associated threat
            $asset = AssetManagement::find($assetID);
    
            if ($asset) {
                // Set the threat name dynamically based on the selected asset
                return redirect()->route('platform.assessment.risk', [
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
