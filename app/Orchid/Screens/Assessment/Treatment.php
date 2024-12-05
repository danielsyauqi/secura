<?php

namespace App\Orchid\Screens\Assessment;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Log;
use App\Models\Assessment\Valuation;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\RadioButtons;
use App\Models\Management\AssetManagement;
use App\Models\Assessment\RMSD as RMSDModel;
use App\Orchid\Layouts\Listener\ProtectionListener;
use App\Orchid\Layouts\Listener\AllSelectionListener;
use App\Orchid\Layouts\Listener\AssetSelectionListener;
use App\Models\Assessment\Treatment as TreatmentModel;
use App\Models\Assessment\Protection as ProtectionModel;
use Illuminate\Routing\Route;

class Treatment extends Screen
{
    public $threat;
    public $asset;
    public $rmsd;
    public $assetID;
    public $valuation;
    public $protection;
    public $treatment;



    public function query($id = null,$threat_id = null): iterable
    {

        if (is_null($threat_id)) {

            return [
                'threat' => null,
                'rmsd' => null,
                'valuation' => null,
                'protection' => null,
                'treatment' => null,
                'asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
                'assetID' => $id,

            ];

            Toast::warning('No threat selected. You can create or select a new threat.');

        } else if (is_null($threat_id) && is_null($id)) {
            return [
                'asset' => null,
                'assetID' => null,
                'threat' => null,
                'protection'   => null,
                'rmsd' => null,
                'valuation' => null,
                'treatment' => null,




            ];

            Toast::warning('No threat and asset selected. You can create or select a new asset and threat.');

        }else{

            return [
                'rmsd' => RMSDModel::where('threat_id', $threat_id)->get(),
                'threat' => Threat::find($threat_id),
                'asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
                'assetID' => $id,
                'valuation' => Valuation::where('asset_id', $id)->get(),
                'protection' => ProtectionModel::where('threat_id', $threat_id)->get(),
                'treatment' => TreatmentModel::where('threat_id', $threat_id)->get(),
    
            ];

        }


      
    }



    public function name(): ?string
    {
        return 'Step 6: Risk Treatment Plan';
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

            Button::make(__('Done'))
                ->icon('bs.check2-all')
                ->method('done')
                ->canSee($this->treatment && $this->treatment->first() ? true : false),
        ];
    }

    public function layout(): array
    {

        /** @var TYPE_NAME $this */
        return [
            
            Layout::accordionClosed([
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
            ]),

            Layout::accordionClosed([

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
            Layout::accordionClosed([

                'Risk Management and Safeguard Data' => Layout::rows([  
                    Group::make([
                        Input::make('safeguard_id')
                            ->title('Safeguard ID')
                            ->value(optional($this->rmsd ? $this->rmsd->first() : null)->safeguard_id)
                            ->readonly()
                            ->style('color: #43494f;'),
    
                        Input::make('existing_safeguard')
                            ->title('Existing Safeguard')
                            ->value(optional($this->rmsd ? $this->rmsd->first() : null)->existing_safeguard)
                            ->readonly()
                            ->style('color: #43494f;'),
                    ]),
    
    
                    Group::make([

                        Input::make('asset_value')
                            ->title('Asset Value')
                            ->value(optional($this->valuation ? $this->valuation->first() : null)->asset_value)
                            ->readonly()
                            ->style('color: #43494f;'),


                        Input::make('risk_level')
                            ->title('Risk Level')
                            ->value(optional($this->rmsd ? $this->rmsd->first() : null)->risk_level)
                            ->readonly()
                            ->style('color: #43494f;'),
                            
                    ]),
    

                ]),

            
            ]),
                
            Layout::accordionShow([    
                'Protection Strategy and Decision' => Layout::Rows([
                        Group::make([
                            Label::make('current')
                                ->title('Current Protection Type:')
                                ->value(optional($this->protection ? $this->protection->first() : null)->protection_type)
                                ->canSee((bool) optional($this->protection ? $this->protection->first() : null)->protection_type),

                            Label::make('current')
                                ->title('Current Protection Strategy:')
                                ->value(optional($this->protection ? $this->protection->first() : null)->protection_strategy)
                                ->canSee((bool) optional($this->protection ? $this->protection->first() : null)->protection_strategy),

                            Label::make('current')
                                ->title('Current Protection ID:')
                                ->value(optional($this->protection ? $this->protection->first() : null)->protection_id)
                                ->canSee((bool) optional($this->protection ? $this->protection->first() : null)->protection_id),
                        ]),


                ]),

            ]),

            
            

            Layout::accordionShow([
                "Treatment Plan" => Layout::rows([

                    Group::make([
                    Input::make('start_date')
                        ->type('date')
                        ->title('Start Date')
                        ->help('The date when the treatment plan starts. ')
                        ->placeholder('YYYY-MM-DD')
                        ->value(optional($this->treatment ? $this->treatment->first() : null)->start_date),

                    Input::make('end_date')
                        ->type('date')
                        ->title('End Date')
                        ->help('The date when the treatment plan ends.')
                        ->placeholder('YYYY-MM-DD')
                        ->value(optional($this->treatment ? $this->treatment->first() : null)->end_date),

                    ]),

                    Group::make([
                      
                        Input::make('personnel')
                            ->title('Personnel')
                            ->help('Include professionals with expertise in security, ICT, and the organization’s core business operations.')
                            ->value(optional($this->treatment ? $this->treatment->first() : null)->personnel),
                            
                        RadioButtons::make("residual_risk")
                            ->title('Residual Risk')
                            ->help('Determine the residual risk.')
                            ->options([
                                'Low' => 'Low',
                                'Medium' => 'Medium',
                                'High' => 'High',
                            ])
                            ->value(optional($this->treatment ? $this->treatment->first() : null)->residual_risk),

                    ]),

                    RadioButtons::make("residual_risk_5")
                            ->title('Residual Risk (Scale 5 Optional)')
                            ->help('Determine the residual risk.')
                            ->options([
                                'Very Low' => 'Very Low',
                                'Low' => 'Low',
                                'Medium' => 'Medium',
                                'High' => 'High',
                                'Very High' => 'Very High',
                            ])
                            ->value(optional($this->treatment ? $this->treatment->first() : null)->scale_5),
                   
                ])

            ]),

         
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

            Layout::modal('assetModal', AssetSelectionListener::class, )->title('Change Asset'),
            
            
        ];
    }



    public function save(Request $request)
    {
        
    try {
        Log::info('Request data (before save):', $request->all());

        TreatmentModel::updateOrCreate(
            ['threat_id' => $this->threat->id], // Use threat_id from the current threat
            [
                'start_date' => $request->input('start_date') ?? $this->treatment->first()->start_date ?? null,
                'end_date' => $request->input('end_date') ?? $this->treatment->first()->end_date ?? null,
                'personnel' => $request->input('personnel') ?? $this->treatment->first()->personnel ?? null,
                'residual_risk' => $request->input('residual_risk') ?? $this->treatment->first()->residual_risk ?? null,
                'scale_5' => $request->input('residual_risk_5') ?? $this->treatment->first()->scale_5 ?? null,


            ]
        );

        Toast::info('Risk Treatment Plan saved successfully.');
        } catch (\Exception $e) {
            Toast::error('An error occurred while saving the Risk Treatment Plan, details: ' . $e->getMessage());
        }
    }

    public function done(Request $request, $threat_id)
    {
    try {
        Log::info('Request data (before done):', $request->all());

        // Check if all necessary details are filled
        if (!$this->rmsd || !$this->treatment || !$this->protection) {
            Toast::error('Please ensure all RMSD, Treatment, and Protection details are filled.');
            return;
        }

        // Check if all fields in RMSD, Treatment, and Protection are filled
        $threat = Threat::where('id', $threat_id)->first() ?? null;
        $rmsd = RMSDModel::where('threat_id', $threat->id)->first() ?? null;
        $treatment = TreatmentModel::where('threat_id', $threat->id)->first() ?? null;
        $protection = ProtectionModel::where('threat_id', $threat->id)->first() ?? null;

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

    public function changeThreat(Request $request)
    {
        $threatID = $request->input('threat.name');
        $assetID = $threatID ? Threat::find($threatID)->asset_id : null;

        try{
            Toast::info('Threat changed.');
            // Redirect to the desired route with the threat's id
            return redirect()->route('platform.assessment.treatment', [
                'id' => $assetID,       // This is the ID of the selected threat
                'threat_id' => $threatID, // This will be passed as a parameter
            ]);


        } catch (\Exception $e) {
            // Handle the case where the threat is not found
            Toast::error('Threat not found.');
            return redirect()->back(); // Redirect back if the threat is not found
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
                return redirect()->route('platform.assessment.treatment', [
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

    public function changeAssetAndThreat(Request $request){
        $assetID = $request->input('asset_name');
        $threatID = $request->input('threat_name');

        try {
            // Fetch the asset and its associated threat
            $asset = AssetManagement::find($assetID);
            $threat = Threat::find($threatID);

            if ($asset && $threat) {
                // Set the threat name dynamically based on the selected asset
                return redirect()->route('platform.assessment.treatment', [
                    'id' => $asset->id,
                    'threat_id' => $threat->id,
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
