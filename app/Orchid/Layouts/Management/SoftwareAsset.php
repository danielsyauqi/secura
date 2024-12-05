<?php

namespace App\Orchid\Layouts\Management;

use Orchid\Screen\TD;
use App\Models\Management\AssetManagement;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\DateTimeSplit;



class SoftwareAsset extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    public $target = 'software';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name',__(key: 'Name'))
                ->cantHide()
                ->render(function (AssetManagement $asset) {
                    if ($asset->type === 'Software') {
                        return ModalToggle::make($asset->name)
                            ->modal('assetDesc')
                            ->asyncParameters([
                                'asset' => $asset->id,
                            ]);
                    }
                    return null;
                }),
                //->render(fn (AssetManagement $assets) => ModalToggle::make($assets->name)),

            TD::make('owner', __(key: 'Owner')),
            
                //->render(fn (AssetManagement $assets) => ModalToggle::make($assets->owner)),

            TD::make('custodian', __(key: 'Custodian')),

                //->render(fn (AssetManagement $assets) => ModalToggle::make($assets->custodian)),

            TD::make('location', __(key: 'Location')),

                //->render(fn (AssetManagement $assets) => ModalToggle::make($assets->location)),

            
            TD::make('quantity', __(key: 'Quantity')),

                //->render(fn (AssetManagement $assets) => ModalToggle::make($assets->quantity)),
            
            TD::make('created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class),
                //->defaultHidden(),

            TD::make('updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class),
                //->align(TD::ALIGN_RIGHT),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (AssetManagement $assets) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                    Link::make(__('Edit Asset'))
                        ->route('platform.management.AssetManagement', $assets->id)
                        ->icon('bs.pencil'),

                    Link::make(__('Risk Assessment Wizard'))
                        ->route('platform.assessment.valuation', $assets->id)
                        ->icon('bs.file-earmark-ruled'),

                    Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->method('remove', [
                            'id' => $assets->id,
                        ]),
            ])),
        ];
    }
}
