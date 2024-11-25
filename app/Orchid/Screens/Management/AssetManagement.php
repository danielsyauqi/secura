<?php

namespace App\Orchid\Screens\Management;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use App\Models\Assessment\Treatment;
use App\Models\Assessment\Valuation;
use App\Models\Assessment\Protection;
use App\Models\Assessment\RMSD;
use App\Orchid\Layouts\Management\AssetListLayout;
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
        return 'A comprehensive guide to basic form controls, including input fields, buttons, checkboxes, and radio buttons.';
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
        Layout::rows([
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
                        '' => '',
                        'Hardware' => 'Hardware',
                        'Software' => 'Software',
                        'People' => 'People',
                        'Data and Information' => 'Data and Information',
                        'Service (Supporting)' => 'Service (Supporting)',
                        'Service (Accessibility)' => 'Service (Accessibility)', 
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
            ->value($this->asset->description ?? ''),
        ]),
        AssetListLayout::class,
    ];
}

    public function create(Request $request): void
    {
        $asset = new AssetManagementModel();
        $models = [
            new Valuation(),
            new Protection(),
            new Treatment(),
        ];

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
            }

            foreach ([
                Valuation::class,
                Threat::class,
                Protection::class,
                Treatment::class,
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
