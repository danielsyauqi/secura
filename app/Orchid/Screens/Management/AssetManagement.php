<?php

namespace App\Orchid\Screens\Management;

use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Collection;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use App\View\Components\TitleAsset;
use App\Models\Assessment\Treatment;
use App\Models\Assessment\Valuation;
use App\Models\Assessment\Protection;
use Illuminate\Http\RedirectResponse;
use App\Orchid\Layouts\Management\HRAsset;
use App\Orchid\Layouts\Management\DataAsset;
use App\Orchid\Layouts\Management\WorkProcess;
use App\Orchid\Layouts\Management\PremiseAsset;
use App\Orchid\Layouts\Management\ServiceAsset;
use App\Orchid\Layouts\Management\HardwareAsset;
use App\Orchid\Layouts\Management\SoftwareAsset;
use App\Orchid\Layouts\Management\AssetSearchLayout;
use App\Models\Management\AssetManagement as AssetManagementModel;

class AssetManagement extends Screen
{
    /** @var AssetManagementModel */
    public $asset;

    /** @var string|null */
    protected $searchQuery;

    /** @var array */
    protected const ASSET_TYPES = [
        'Hardware' => 'Hardware',
        'Software' => 'Software',
        'Work Process' => 'Work Process',
        'Human Resources' => 'Human Resources',
        'Data and Information' => 'Data and Information',
        'Services' => 'Services',
        'Premise' => 'Premise',
    ];

    /** @var array */
    protected const VALIDATION_RULES = [
        'description' => 'required|string',
        'custodian' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'type' => 'required|string',
        'owner' => 'required|string|max:255',
    ];

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param int|null $id
     * @return array
     */
    public function query(?int $id = null): array
    {
        $this->asset = $id ? AssetManagementModel::findOrFail($id) : new AssetManagementModel();
        $this->searchQuery = request('filter.search');

        $assets = $this->getFilteredAssets();

        return [
            'asset' => $this->asset,
            'assets' => $assets,
            'hardware' => $assets->where('type', 'Hardware'),
            'software' => $assets->where('type', 'Software'),
            'work' => $assets->where('type', 'Work Process'),
            'data' => $assets->where('type', 'Data and Information'),
            'service' => $assets->where('type', 'Services'),
            'resource' => $assets->where('type', 'Human Resources'),
            'premise' => $assets->where('type', 'Premise'),
            'filter' => [
                'search' => $this->searchQuery,
            ],
        ];
    }

    /**
     * Get filtered assets based on search query.
     *
     * @return Collection
     */
    protected function getFilteredAssets(): Collection
    {
        if ($this->searchQuery) {
            $results = AssetManagementModel::search($this->searchQuery)->get();
            return $results;
        }

        return AssetManagementModel::all();
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
        return "Asset management is the process of systematically managing an organization's assets throughout their lifecycle to maximize value, minimize risk, and ensure efficient utilization.";
    }

    /**
     * Get the screen's command bar.
     *
     * @return array
     */
    public function commandBar(): array
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
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::component(TitleAsset::class),
            AssetSearchLayout::class,
            Layout::tabs([
                'Add Asset' => $this->getAssetInformationLayout(),
                'Asset List' => $this->getAssetTabsLayout(),
            ]),
            $this->getAssetDescriptionModal(),
        ];
    }

    /**
     * Get asset information layout.
     *
     * @return Layout
     */
    protected function getAssetInformationLayout(): object
    {
        return 
            Layout::rows([
                $this->getBasicInfoFields(),
                $this->getLocationInfoFields(),
                $this->getTypeInfoFields(),
                $this->getDescriptionField(),
                Button::make($this->asset->exists ? __('Save Asset') : __('Add Asset'))
                    ->icon($this->asset->exists ? 'bs.save' : 'bs.plus')
                    ->method($this->asset->exists ? 'createOrUpdate' : 'create')
                    ->parameters([
                        'id' => $this->asset->id,
                    ])
                    ->type(Color::PRIMARY),
            ]);
        
    }

    /**
     * Get basic info fields group.
     *
     * @return Group
     */
    protected function getBasicInfoFields(): object
    {
        return Group::make([
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
        ]);
    }

    /**
     * Get location info fields group.
     *
     * @return Group
     */
    protected function getLocationInfoFields(): object
    {
        return Group::make([
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
        ]);
    }

    /**
     * Get type info fields group.
     *
     * @return Group
     */
    protected function getTypeInfoFields(): object
    {
        return Group::make([
            Input::make('owner')
                ->title('Owner')
                ->placeholder('Enter owner')
                ->help('Example: Information Technology Dept.')
                ->value($this->asset->owner ?? ''),

            Select::make('type')
                ->options(array_merge(['' => 'Choose Asset Type'], self::ASSET_TYPES))
                ->placeholder('Enter Asset type')
                ->title('Asset Type')
                ->help('Example: Hardware, Software, etc.')
                ->value($this->asset->type ?? ''),
        ]);
    }

    /**
     * Get description field.
     *
     * @return TextArea
     */
    protected function getDescriptionField(): object
    {
        return TextArea::make('description')
            ->title('Description')
            ->placeholder('Enter description')
            ->help('Example: This is a laptop, This is a desktop, etc.')
            ->rows(4)
            ->style('width: 49.5%;')
            ->value($this->asset->description ?? '');
    }

    /**
     * Get asset tabs layout.
     *
     * @return Layout
     */
    protected function getAssetTabsLayout(): object
    {
        return Layout::tabs([
            'Hardware' => HardwareAsset::class,
            'Software' => SoftwareAsset::class,
            'Data and Information' => DataAsset::class,
            'Services' => ServiceAsset::class,
            'Human Resources' => HRAsset::class,
            'Premise' => PremiseAsset::class,
            'Work Process' => WorkProcess::class,
        ]);
    }

    /**
     * Get asset description modal.
     *
     * @return Layout
     */
    protected function getAssetDescriptionModal(): object
    {
        return Layout::modal('assetDesc',
            Layout::rows([
                TextArea::make('asset')
                    ->title('Description')
                    ->readonly()
                    ->rows(10)
                    ->style('color: #43494f;'),
            ])
        )->title('Asset Description')->withoutApplyButton()->deferred('loadUserOnOpenModal');
    }

    /**
     * Handle the search button click.
     *
     * @return RedirectResponse
     */
    public function search(): RedirectResponse
    {
        $search = request('filter.search');
        return redirect()->route('platform.management.AssetManagement', ['filter' => ['search' => $search]]);
    }

    /**
     * Handle the search request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function searchAssets(Request $request): RedirectResponse
    {
        $request->validate([
            'filter.search' => 'nullable|string|max:255',
        ]);

        return redirect()->route('platform.management.asset', [
            'filter' => [
                'search' => $request->input('filter.search'),
            ],
        ]);
    }

    /**
     * Load user data for modal.
     *
     * @param AssetManagementModel $asset
     * @return array
     */
    public function loadUserOnOpenModal(AssetManagementModel $asset): array
    {
        return [
            'asset' => $asset->description,
        ];
    }

    /**
     * Create a new asset.
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request): void
    {
        try {
            $this->validateAsset($request, true);
            $asset = $this->saveAsset(new AssetManagementModel(), $request);
            $this->createRelatedModels($asset->id);
            
            Toast::info('Asset added successfully.');
        } catch (\Exception $e) {
            Toast::error('Failed to add asset: ' . $e->getMessage());
        }
    }

    /**
     * Create or update an asset.
     *
     * @param Request $request
     * @param int|null $id
     * @return void
     */
    public function createOrUpdate(Request $request, ?int $id = null): void
    {
        try {
            $asset = $id ? AssetManagementModel::findOrFail($id) : new AssetManagementModel();
            $this->validateAsset($request, !$id || $request->input('name') !== $asset->name);
            $this->saveAsset($asset, $request);
            
            Toast::info('Asset updated successfully.');
        } catch (\Exception $e) {
            Toast::error('Failed to update asset: ' . $e->getMessage());
        }
    }

    /**
     * Validate asset data.
     *
     * @param Request $request
     * @param bool $validateName
     * @return void
     */
    protected function validateAsset(Request $request, bool $validateName): void
    {
        $rules = self::VALIDATION_RULES;
        if ($validateName) {
            $rules['name'] = 'required|unique:asset_management,name';
        }
        
        $request->validate($rules);
    }

    /**
     * Save asset data.
     *
     * @param AssetManagementModel $asset
     * @param Request $request
     * @return AssetManagementModel
     */
    protected function saveAsset(AssetManagementModel $asset, Request $request): AssetManagementModel
    {
        $asset->fill($request->only([
            'name',
            'description',
            'custodian',
            'location',
            'quantity',
            'type',
            'owner',
        ]));
        
        if (!$asset->exists) {
            $asset->secura_id = 1;
        }
        
        $asset->save();
        return $asset;
    }

    /**
     * Create related models for a new asset.
     *
     * @param int $assetId
     * @return void
     */
    protected function createRelatedModels(int $assetId): void
    {
        $valuation = new Valuation();
        $valuation->asset_id = $assetId;
        $valuation->save();
    }

    /**
     * Remove an asset.
     *
     * @param Request $request
     * @return void
     */
    public function remove(Request $request): void
    {
        try {
            $asset = AssetManagementModel::findOrFail($request->get('id'));
            $this->deleteRelatedModels($asset);
            $asset->delete();
            
            Toast::info('Asset deleted successfully.');
        } catch (\Exception $e) {
            Toast::error('Failed to delete asset: ' . $e->getMessage());
        }
    }

    /**
     * Delete related models before deleting an asset.
     *
     * @param AssetManagementModel $asset
     * @return void
     */
    protected function deleteRelatedModels(AssetManagementModel $asset): void
    {
        // Delete related RMSD, Protection, and Treatment records
        $threats = Threat::where('asset_id', $asset->id)->get();
        foreach ($threats as $threat) {
            RMSD::where('threat_id', $threat->id)->delete();
            Protection::where('threat_id', $threat->id)->delete();
            Treatment::where('threat_id', $threat->id)->delete();
        }

        // Delete Valuation and Threat records
        Valuation::where('asset_id', $asset->id)->delete();
        Threat::where('asset_id', $asset->id)->delete();
    }
}
