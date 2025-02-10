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
use App\Models\Assessment\Protection as ProtectionModel;

class Protection extends Screen
{
    public $threat;
    public $asset;
    public $rmsd;
    public $assetID;
    public $valuation;
    public $protection;
    public $protection_id;




    public function query($id = null,$threat_id = null): iterable
    {

        if (is_null($threat_id)) {
            Toast::warning('No threat selected. You can create or select a new threat.');


            return [
                'threat' => null,
                'rmsd' => null,
                'valuation' => null,
                'protection' => null,
                'asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
                'assetID' => $id,

            ];


        } else if (is_null($threat_id) && is_null($id)) {
            Toast::warning('No threat and asset selected. You can create or select a new asset and threat.');

            return [
                'asset' => null,
                'assetID' => null,
                'threat' => null,
                'protection'   => null,
                'rmsd' => null,
                'valuation' => null,



            ];


        }

        $this->protection = ProtectionModel::where('threat_id', $threat_id)->get();
        return [
            'rmsd' => RMSDModel::where('threat_id', $threat_id)->get(),
            'threat' => Threat::find($threat_id),
            'asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
            'assetID' => $id,
            'valuation' => Valuation::where('asset_id', $id)->get(),
            'protection' => $this->protection,    
            'protection_strategy' => $this->protection->first()->protection_strategy ?? null,        
            'decision' => $this->protection->first()->decision ?? null, 
            'protection_id' => $this->protection->first()->protection_id ?? null,
        ];
    }



    public function name(): ?string
    {
        return 'Step 5: Protection Strategy and Decision';
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
            Layout::accordion([
                'Asset Information' => Layout::rows([
                    Group::make([
                        Input::make('asset.name')
                            ->title('Asset Name')
                            ->style('color: #43494f;')
                            ->value(value: optional(value: $this->asset)->type)
                            ->readonly(),

                            Input::make('threat.name')
                                ->title('Current Threat')
                                ->style('color: #43494f;')
                                ->value(optional($this->threat)->threat_name)
                                ->readonly(),
                    ]),

                    Group::make([

                    ModalToggle::make('Change Asset')
                        ->modal('assetModal')
                        ->method('changeAsset')
                        ->icon('bs.box-arrow-up-right'),

                    ModalToggle::make(
                            !$this->threat
                                ? (!$this->asset ? __('Choose Asset and Threat') : __('Choose Threat'))
                                : __('Change Threat')
                        )->icon('bs.box-arrow-up-right')
    
                        ->modal(!$this->threat && !$this->asset ? 'chooseAssetAndThreat' : 'chooseThreat')
                        ->method(!$this->threat && !$this->asset ? 'changeAssetAndThreat' : 'changeThreat')
                        ->open(!$this->threat),

                    ]),

                    Group::make([

                        Label::make('risk_level')
                        ->title('Risk Level: ')
                        ->value(optional($this->rmsd?->first())->risk_level),

                        Label::make('current')
                        ->title('Safeguard ID:')
                        ->value(optional($this->rmsd?->first())->safeguard_id),
                    ]),
                ]),
            ]),

            ProtectionListener::class,

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

        $protection = ProtectionModel::updateOrCreate(
            ['threat_id' => $this->threat->id], // Use threat_id from the current threat
            [
                'protection_id' => $request->input('protection_id') ?? $this->protection->first()->protection_id ?? null,
                'protection_strategy' => $request->input('protection_strategy') ?? $this->protection->first()->protection_strategy ?? null,
                'decision' => $request->input('decision') ?? $this->protection->first()->decision ?? null, 
            ]
        );

        Log::info('Protection Strategy and Decision updated successfully in the database.', ['protection' => $protection]);
        Toast::info('Protection Strategy and Decision saved successfully.');
        } catch (\Exception $e) {
            Toast::error('An error occurred while saving the Protection Strategy and Decision, details: ' . $e->getMessage());
        }
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
        $threatID = $request->input('threat.name');
        $assetID = $threatID ? Threat::find($threatID)->asset_id : null;

        try{
            Toast::info('Threat changed.');
            // Redirect to the desired route with the threat's id
            return redirect()->route('platform.assessment.protection', [
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
                return redirect()->route('platform.assessment.protection', [
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
                return redirect()->route('platform.assessment.protection', [
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
