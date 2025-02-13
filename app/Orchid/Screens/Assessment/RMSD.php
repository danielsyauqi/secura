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
use App\Models\Assessment\Valuation;
use Orchid\Screen\Actions\ModalToggle;
use App\Models\Management\AssetManagement;
use App\Models\Assessment\RMSD as RMSDModel;
use App\Orchid\Layouts\Listener\ImpactListener;
use App\Orchid\Layouts\Listener\SafeguardListener;
use App\Orchid\Layouts\Listener\VulnerableListener;
use App\Orchid\Layouts\Listener\AllSelectionListener;
use App\Orchid\Layouts\Listener\AssetSelectionListener;

class RMSD extends Screen
{
    public $threat;
    public $asset;
    public $rmsd;
    public $assetID;
    public $impact_level;
    public $business_loss;
    public $asset_value_5;
    public $business_loss_5;
    public $impact_level_5;

    public function query($id = null, $threat_id = null): iterable
    {
        if (is_null($threat_id) && is_null($id)) {
            Toast::warning('No threat and asset selected. You can create or select a new asset and threat.');
            return [
                'asset' => null,
                'assetID' => null,
                'threat' => null,
                'rmsd' => null,
                'impact_level' => null,
                'business_loss' => null,
            ];
        }

        if (is_null($threat_id)) {
            Toast::warning('No threat selected. You can create or select a new threat.');
            return [
                'threat' => null,
                'rmsd' => null,
                'impact_level' => null,
                'business_loss' => null,
                'asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
                'assetID' => $id,
            ];
        }


        return [
            'rmsd' => RMSDModel::where('threat_id', $threat_id)->get(),
            'threat' => Threat::find($threat_id),
            'asset' => $id ? AssetManagement::findOrFail($id) : new AssetManagement(),
            'assetID' => $id,

            'asset_value_5' => optional(Valuation::where('asset_id', $id)->first())->asset_value_5 ?? null,
            'business_loss_5' => optional(RMSDModel::where('threat_id', $threat_id)->first())->business_loss_5 ?? null,
            'impact_level_5' => optional(RMSDModel::where('threat_id', $threat_id)->first())->impact_level_5 ?? null,
            'asset_value' => optional(Valuation::where('asset_id', $id)->first())->asset_value ?? null,
            'impact_level' => optional(RMSDModel::where('threat_id', $threat_id)->first())->impact_level ?? null,
            'business_loss' => optional(RMSDModel::where('threat_id', $threat_id)->first())->business_loss ?? null,

            'vuln_group' => optional(RMSDModel::where('threat_id', $threat_id)->first())->vuln_group ?? null,
            'vuln_name' => optional(RMSDModel::where('threat_id', $threat_id)->first())->vuln_name ?? null,
            'safeguard_id' => optional(RMSDModel::where('threat_id', $threat_id)->first())->safeguard_id ?? null,
            'safeguard_group' => optional(RMSDModel::where('threat_id', $threat_id)->first())->safeguard_group ?? null,


        ];
    }

    public function name(): ?string
    {
        return 'Step 3: Risk Management and Safeguard Data';
    }

    public function description(): ?string
    {
        return "Risk management and data safeguarding involve strategies to identify, assess, and mitigate risks that could compromise the integrity, confidentiality, and availability of sensitive information. It includes methods for evaluating discrepancies or deviations in data, which can indicate vulnerabilities or threats to data security. Effective risk management helps to prevent unauthorized access, data breaches, and system failures, ensuring that critical information is protected through measures such as encryption, access control, monitoring, and regular audits. By proactively addressing potential risks and implementing safeguards, organizations can secure their data, maintain compliance with regulations, and ensure business continuity.";
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
                ]),
            ]),

            Layout::modal('chooseAssetAndThreat', AllSelectionListener::class)
                ->title(__('Choose Asset and Threat')),

            Layout::modal('chooseThreat', AllSelectionListener::class)
                ->title(__('Choose Threat')),

            Layout::modal('assetModal', AssetSelectionListener::class)->title('Change Asset'),

            Layout::tabs([
                'Vulnerable Form' => [
                    VulnerableListener::class,
                ],

                'Safeguards Form' => [
                    SafeguardListener::class,
                ],

                'Impact Form' => [
                    ImpactListener::class,
                ],
            ]),
        ];
    }

    public function save(Request $request)
    {
        try {
            $flag = 0;

            Log::info('Request data:', $request->all());

            RMSDModel::updateOrCreate(
                ['threat_id' => $this->threat->id],
                [
                    'safeguard_id' => $request->input('safeguard_id') ?? optional($this->rmsd->first())->safeguard_id,
                    'safeguard_group' => $request->input('safeguard_group') ?? optional($this->rmsd->first())->safeguard_group,
                    'impact_level' => $request->input('impact_level') ?? optional($this->rmsd->first())->impact_level,
                    'business_loss' => $request->input('business_loss') ?? optional($this->rmsd->first())->business_loss,
                    'likelihood' => $request->input('likelihood') ?? optional($this->rmsd->first())->likelihood,
                    'vuln_group' => $request->input('vuln_group') ?? optional($this->rmsd->first())->vuln_group,
                    'vuln_name' => $request->input('vuln_name') ?? optional($this->rmsd->first())->vuln_name,
                    'impact_level_5' => $request->input('impact_level_5') ?? optional($this->rmsd->first())->impact_level_5,
                    'business_loss_5' => $request->input('business_loss_5') ?? optional($this->rmsd->first())->business_loss_5,
                ]
            );

            if ($request->input('business_loss') !== optional($this->rmsd->first())->business_loss && optional($this->rmsd->first()) !== null) {
                RMSDModel::where('threat_id', $this->threat->id)
                    ->update(['risk_level' => null, 'likelihood' => null]);

                $flag=1;
            }

            if ($request->input('business_loss_5') !== optional($this->rmsd->first())->business_loss_5 && optional($this->rmsd->first()) !== null) {
                RMSDModel::where('threat_id', $this->threat->id)
                    ->update(['risk_level_5' => null, 'likelihood_5' => null]);

                $flag=1;
            }

            if ($flag === 1) {
                Toast::info('Risk Level (Scale 3) has been reset in RMSD due to changes in Business Loss.');
                Threat::where('asset_id', $this->asset->id)->update(['status' => 'Draft']);
            } elseif ($flag === 2) {
                Toast::info('Risk Level (Scale 5) has been reset in RMSD due to changes in Business Loss.');
                Threat::where('asset_id', $this->asset->id)->update(['status' => 'Draft']);
            } else {
                Toast::info('RMSD saved successfully.');
            }
        } catch (\Exception $e) {
            Toast::error('An error occurred while saving the RMSD, details: ' . $e->getMessage());
        }
    }

    public function next(Request $request)
    {
        return redirect()->route('platform.assessment.risk', [
            'id' => $request->id,
            'threat_id' => $this->threat->id,
        ]);
    }

    public function changeThreat(Request $request)
    {
        $threatID = $request->input('threat.name');
        $assetID = $threatID ? Threat::find($threatID)->asset_id : null;

        try {
            Toast::info('Threat changed.');
            return redirect()->route('platform.assessment.rmsd', [
                'id' => $assetID,
                'threat_id' => $threatID,
            ]);
        } catch (\Exception $e) {
            Toast::error('Threat not found.');
            return redirect()->back();
        }
    }

    public function changeAsset(Request $request)
    {
        $assetID = $request->input('asset_name');

        try {
            $asset = AssetManagement::find($assetID);

            if ($asset) {
                return redirect()->route('platform.assessment.rmsd', [
                    'id' => $asset->id,
                ]);
            } else {
                Toast::error('No asset found for the selected asset.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toast::error('An error occurred while changing the asset: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function changeAssetAndThreat(Request $request)
    {
        $assetID = $request->input('asset_name');
        $threatID = $request->input('threat_name');

        try {
            $asset = AssetManagement::find($assetID);
            $threat = Threat::find($threatID);

            if ($asset && $threat) {
                return redirect()->route('platform.assessment.rmsd', [
                    'id' => $asset->id,
                    'threat_id' => $threat->id,
                ]);
            } else {
                Toast::error('No threat found for the selected asset.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toast::error('An error occurred while changing the asset: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
