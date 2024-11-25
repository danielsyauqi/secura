<?php

namespace App\Orchid\Screens\Assessment;

use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Radio;
use Orchid\Screen\Fields\Select;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Models\Assessment\Valuation;
use Orchid\Screen\Layouts\Accordion;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\RadioButtons;
use App\Models\Management\AssetManagement;
use App\Models\Assessment\RMSD as RMSDModel;
use App\Orchid\Layouts\Listener\ImpactListener;
use App\Orchid\Layouts\Listener\SafeguardListener;
use App\Orchid\Layouts\Assessment\VulnGroupOptions;
use App\Orchid\Layouts\Listener\VulnerableListener;
use App\Orchid\Layouts\Listener\AssetSelectionListener;
use App\Orchid\Layouts\Listener\ThreatSelectionListener;

class RMSD extends Screen
{
    public $threat;
    public $asset;

    public $rmsd;

    public $assetID;


   

    public function query($id,$threat_id): iterable
    {
        $this->threat = Threat::find($threat_id);
        $this->rmsd = RMSDModel::where('threat_id', $threat_id)->get();
        $this->asset = $this->threat ? $this->threat->asset : null;
        $this ->assetID = $id;

        $impactLevel = optional($this->rmsd->first())->impact_level;


        

        if (!$this->threat) {
            Toast::warning('No asset selected. You can create a new valuation or select an asset.');
        }

        return [
            'rmsd' => $this->rmsd,
            'threat' => $this->threat,
            'asset' => $this->asset,
            'assetID' => $this->assetID,

            'impact_level' => $impactLevel,



        ];
    }

    

    public function name(): ?string
    {
        return 'Step 3: Threat, Vulnerability, and Safeguard';
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


            Layout::rows([
                Group::make([
                    Input::make('threat.name')
                            ->title('Current Threat')
                            ->value(optional($this->threat)->threat_name)
                            ->readonly(),
                            
                    Input::make('threat.group')
                        ->title('Threat Group')
                        ->value(optional($this->threat)->threat_group)
                        ->readonly(),
                ]),
                ModalToggle::make('Change Threat')
                    ->modal('threatModal')
                    ->method('changeThreat')
                    ->icon('bs.box-arrow-up-right'),


                
            ]),

            Layout::modal('threatModal', ThreatSelectionListener::class, )->title('Change Threat'),

            
            Layout::tabs([
                'Vulnerable Form' =>[
                    Layout::rows([
                        Group::make(group: [
                            Label::make('current')
                                ->title('Current Vulnerable Group:')
                                ->value(optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->vuln_group)
                                ->canSee((bool) optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->vuln_group),
        
                            Label::make('current')
                                ->title('Current Vulnerable Details:')
                                ->value(optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->vuln_name)
                                ->canSee((bool) optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->vuln_name),
            
                        ]),
                    ])->canSee(
                        (bool) optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->vuln_group &&
                        optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->vuln_name
        
                    ),
                    
                    VulnerableListener::class,
                ], 
                
                'Safeguards Form' => [
                    Layout::rows([
                        Group::make(group: [
                            Label::make('current')
                                ->title('Current Safeguards Type:')
                                ->value(optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->safeguard_type)
                                ->canSee((bool) optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->safeguard_type),
        
        
                            Label::make('current')
                                ->title('Current Safeguard Group:')
                                ->value(optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->safeguard_group)
                                ->canSee((bool) optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->safeguard_group),
        
                            Label::make('current')
                                ->title('Current Safeguard ID:')
                                ->value(value: optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->safeguard_id)
                                ->canSee((bool) optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->safeguard_id),
            
                        ]),
                    ])->canSee(
                        (bool) optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->safeguard_type &&
                        optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->safeguard_group &&
                        optional($this->rmsd->firstWhere('threat_id', $this->threat->id))->safeguard_id
                    ),
                    SafeguardListener::class,

                    Layout::rows([

                        Group::make([
                        
                            Input::make("existing_safeguard")
                                ->title('Existing Safeguards')
                                ->help('Write the existing safeguards.')
                                ->value(optional($this->rmsd->first())->existing_safeguard), // Display the existing safeguard value
        
                            Input::make("others_safeguard")
                                ->title('Others Safeguards')
                                ->help('Write the others safeguards.')
                                ->value(optional($this->rmsd->first())->others_safeguard), // Display the existing safeguard value
                        ]),
        
                    ]),

                ],


                'Impact Form' => [
                    Layout::rows([
                            Input::make("asset_value")
                                ->title('Asset Value')
                                ->disabled()
                                ->value(optional(Valuation::query()->first())->asset_value)
                                ->help('Please refer from this asset value.')
                                ->style('color: #43494f;'),
                            
                    ]),
                    ImpactListener::class,

                ],

                'Likelihood Form' =>  [

                    Layout::rows([
                        Input::make("impact_level")
                            ->title('Impact Level')
                            ->disabled()
                            ->value(optional(Valuation::query()->first())->asset_value)
                            ->help('Please refer from this impact level.')
                            ->style('color: #43494f;'),
                        
                    ]),

                    Layout::rows([
                        
                        RadioButtons::make("likelihood")
                                ->title('Likelihood Scale')
                                ->options([
                                    'L' => 'Low',
                                    'M' => 'Medium',
                                    'H' => 'High',
                                ])
                                ->value(optional($this->rmsd->first())->likelihood)
                                ->help('Determine the likelihood.'),
        
                    ]),
                    
                ],
            ]),
        ];
    }



    public function save(Request $request)
    {
        try {
            // Directly pass values using null coalescing operator in the updateOrCreate method
            RMSDModel::updateOrCreate(
                ['threat_id' => $this->threat->id], // Use threat_id from the current threat (from headers or query)
                [
                    'safeguard_id' => $request->input('safeguard_id') ?? $this->rmsd->first()->safeguard_id,
                    'safeguard_type' => $request->input('safeguard_type') ?? $this->rmsd->first()->safeguard_type,
                    'safeguard_group' => $request->input('safeguard_group') ?? $this->rmsd->first()->safeguard_group,
                    'existing_safeguard' => $request->input('existing_safeguard'),
                    'others_safeguard' => $request->input('others_safeguard'),
                    'impact_level' => $request->input('impact_level'),
                    'business_loss' => $request->input('business_loss'),
                    'likelihood' => $request->input('likelihood'),
                    'vuln_group' => $request->input('vuln_group') ?? $this->rmsd->first()->vuln_group,
                    'vuln_name' => $request->input('vuln_name') ?? $this->rmsd->first()->vuln_name,
                ]
            );

            Toast::info('Safeguard saved successfully.');

           

        } catch (\Exception $e) {
            Toast::error('An error occurred while saving the safeguard, details: ' . $e->getMessage());
        }
    }

    public function next(Request $request)
    {
        return redirect()->route('platform.assessment.rmsd', [
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
            return redirect()->route('platform.assessment.rmsd', [
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
            
            if (!$asset) {
                Toast::error('Asset not found.');
                return redirect()->back();
            }

            // Get the first associated threat for the asset
            $threat = Threat::where('asset_id', $asset->id)->first();

            if ($threat) {
                // Set the threat name dynamically based on the selected asset
                return redirect()->route('platform.assessment.rmsd', [
                    'id' => $asset->id,
                    'threat_id' => $threat->id, // Use the first threat found for the asset
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
