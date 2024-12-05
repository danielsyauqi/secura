<?php

namespace App\Orchid\Screens\Management;


use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use App\Models\Assessment\Treatment;
use App\Models\Assessment\Valuation;
use App\Models\Assessment\Protection;
use App\Orchid\Layouts\Management\HRAsset;
use App\Orchid\Layouts\Management\DataAsset;
use App\Orchid\Layouts\Management\WorkProcess;
use App\Orchid\Layouts\Management\PremiseAsset;
use App\Orchid\Layouts\Management\ServiceAsset;
use App\Orchid\Layouts\Management\HardwareAsset;
use App\Orchid\Layouts\Management\SoftwareAsset;
use App\Models\Management\AssetManagement as AssetManagementModel;

class AssetManagement extends Screen{

    public $asset;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(int $id = null): iterable
    {
        $this->asset = $id ? AssetManagementModel::findOrFail($id) : new AssetManagementModel();

        return [
            'asset' => $this->asset,
            'assets' => AssetManagementModel::all(),
            'hardware' => AssetManagementModel::where('type', 'Hardware')->get(),
            'software' => AssetManagementModel::where('type', 'Software')->get(),
            'work' => AssetManagementModel::where('type', 'Work Process')->get(),
            'data' => AssetManagementModel::where('type', 'Data and Information')->get(),
            'service' => AssetManagementModel::where('type', 'Services')->get(),
            'resource' => AssetManagementModel::where('type', 'Human Resources')->get(),
            'premise' => AssetManagementModel::where('type', 'Premise')->get(),

        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Asset Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return "Asset management is the process of systematically managing an organization's assets throughout their lifecycle to maximize value, minimize risk, and ensure efficient utilization. It involves activities such as the acquisition, tracking, maintenance, and disposal of assets, whether they are physical (like machinery, equipment, or infrastructure), financial (stocks, bonds, etc.), or intangible (software, intellectual property). The goal is to optimize asset performance, reduce operational costs, and ensure compliance with regulations, all while leveraging technology to enhance decision-making and streamline asset-related processes. Effective asset management contributes to better financial planning, risk mitigation, and overall organizational efficiency.";
    }


    public function commandBar(): iterable
    {
        return [
            Button::make($this->asset->exists ? __('Save Asset') : __('Add Asset'))
                ->icon($this->asset->exists ? 'bs.save' : 'bs.plus')
                ->method($this->asset->exists ? 'createOrUpdate' : 'create')
                ->parameters([
                    'id' => $this->asset->id,
                ]),
        ];
    }
    
    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
{
    return [
        Layout::accordion([
            'Asset Information' => Layout::rows([
                Group::make([
                    Input::make('name')
                        ->title('Asset Name')
                        ->placeholder('Enter asset name')
                        ->help('Example: Laptop, Desktop, etc.')
                        ->value($this->asset->name ?? ''),
    
                    Input::make('quantity')
                        ->title('Quantity')
                        ->placeholder('Enter quantity')
                        ->help('Example: 10, 20, etc.')   
                        ->value($this->asset->quantity ?? ''),
                ]),
                Group::make([
                    Input::make('custodian')
                        ->title('Custodian')
                        ->placeholder('Enter custodian name')
                        ->help('Example: John Doe, Jane Doe, etc.')
                        ->value($this->asset->custodian ?? ''),
    
                    Input::make('location')
                        ->title('Location')
                        ->placeholder('Enter location')
                        ->help('Example: Room 101, Room 102, etc.')
                        ->value($this->asset->location ?? ''),
                ]),
                Group::make([
                    Input::make('owner')
                    ->title('Owner')
                    ->placeholder('Enter owner')
                    ->help('Example: Information Technology Dept.')
                    ->value($this->asset->owner ?? ''),
    
                    Select::make("type")
                    
                        ->options([
                            '' => 'Choose Asset Type',
                            'Hardware' => 'Hardware',
                            'Software' => 'Software',
                            'Work Process' => 'Work Process',
                            'Human Resources' => 'Human Resources',
                            'Data and Information' => 'Data and Information',
                            'Services' => 'Services',
                            'Premise' => 'Premise', 
                        ])
                        ->placeholder('Enter Asset type')
                        ->title('Asset Type')
                        ->help('Example: Hardware, Software, etc.')
                        ->value($this->asset->type ?? ''),
                ]),
                TextArea::make('description')
                ->title('Description')
                ->placeholder('Enter description')
                ->help('Example: This is a laptop, This is a desktop, etc.')
                ->rows(4)
                ->style('width: 49.5%;')
                ->value($this->asset->description ?? ''),

            ]),
            
            
        ]),
        

        Layout::accordionClosed([
            "Hardware"=> HardwareAsset::class,
            "Software"=> SoftwareAsset::class,
            "Data and Information"=> DataAsset::class,
            "Services"=> ServiceAsset::class,
            "Human Resources"=> HRAsset::class,
            "Premise"=> PremiseAsset::class,
            "Work Process"=> WorkProcess::class,
        ]),
        
        Layout::modal('assetDesc',
            Layout::rows([
                TextArea::make('asset')
                ->title('Description')
                ->readonly()
                ->rows(10)
                ->style('color: #43494f;'),
            ])
        
        )->title('Asset Description')->withoutApplyButton()->deferred('loadUserOnOpenModal'),
        
    ];
    
}

    public function loadUserOnOpenModal(AssetManagementModel $asset): iterable
    {
        
        return [
            'asset' => $asset->description,
        ];
    }


    public function create(Request $request): void
    {

            // Validate for duplicate name
        $request->validate([
            'name' => 'required|unique:asset_management,name',
            'description' => 'required|string',
            'custodian' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|string',
            'owner' => 'required|string|max:255', 
        ]);
        
        $asset = new AssetManagementModel();
        

        try {
            $asset->fill($request->only([
                'name',
                'description' ,
                'custodian' ,
                'location' ,
                'quantity',
                'type',
                'owner',
            ]));
            $asset->sims_id = 1;
            $asset->save();

            $assetId = $asset->id;


            $models = [
                new Valuation(),

            ];
            foreach ($models as $model) {
                $model->asset_id = $assetId;
                $model->save();
            }


            

            Toast::info('Asset added successfully.');
        } catch (\Exception $e) {
            Toast::error('Failed to add asset: ' . $e->getMessage());
        }
    }

    public function createOrUpdate(Request $request, int $id = null)
    {

        // Validate for duplicate name
        $request->validate([
            'name' => 'required|unique:asset_management,name,' . $id, 
            'description' => 'required|string',
            'custodian' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|string',
            'owner' => 'required|string|max:255',
        ]);

        $asset = $id ? AssetManagementModel::findOrFail($id) : new AssetManagementModel();

        try {
            $asset->fill($request->only([
                'name',
                'description' ,
                'custodian' ,
                'location' ,
                'quantity',
                'type',
                'owner',

            ]));
            $asset->sims_id = 1;
            $asset->save();

            Toast::info('Asset saved successfully.');
            return redirect()->route('platform.management.AssetManagement');

        } catch (\Exception $e) {
            Toast::error('Failed to save asset: ' . $e->getMessage());
        }
    }

    public function remove(Request $request): void
    {
        $id = $request->get('id');
        $asset = AssetManagementModel::find($id);

        if ($asset) {
            // Delete the valuation associated with the asset

            // Delete related models with threat_id
            $threats = Threat::where('asset_id', $id)->get();
            foreach ($threats as $threat) {
                RMSD::where('threat_id', $threat->id)->delete();
                Protection::where('threat_id', $threat->id)->delete();
                Treatment::where('threat_id', $threat->id)->delete();
            }

            foreach ([
                Valuation::class,
                Threat::class,

            ] as $model) {
                $model::where('asset_id', $id)->delete();
            }

            // Delete the asset
            $asset->delete();
            
            Toast::info('Asset and its related data deleted successfully.');
        } else {
            Toast::error('Failed to delete asset.');
        }
    }

}
