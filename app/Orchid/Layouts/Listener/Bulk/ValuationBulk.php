<?php

namespace App\Orchid\Layouts\Listener\Bulk;


use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;


class ValuationBulk extends Listener
{

    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['confidential', 'integrity', 'availability', 'confidential_5', 'integrity_5', 
                        'availability_5', 'asset_value', 'asset_value_5', 'depend_on', 'depended_asset'];

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    protected function layouts(): iterable
    {
        return [
            Layout::tabs([
                "Scale 3" => Layout::rows([

                    Input::make("depend_on")
                    ->title('Asset Depend On')
                    ->help('Please select the asset that this asset depends on.')
                    ->value($this->query->get('depend_on')),

                    Input::make("depended_asset")
                    ->help('Please select the asset that depeneded on current asset.')
                    ->value($this->query->get('depended_asset'))
                    ->title('Depended Asset'),

                    Select::make("confidential")
                        ->help('Please select the confidentiality level of the asset.')
                        ->title('Confidentiality')
                        ->options([
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                        ])
                        ->value($this->query->get('confidential')),
            
                    Select::make("integrity")
                        ->help('Please select the integrity level of the asset.')
                        ->title('Integrity')
                        ->options([
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                        ])
                        ->value($this->query->get('integrity')),
            
                    Select::make("availability")
                        ->help('Please select the availability level of the asset.')
                        ->title('Availability')
                        ->options([
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                        ])
                        ->value($this->query->get('availability')),

                    Input::make('asset_value')
                        ->help('This is final result of asset value.')
                        ->title('Asset Value')
                        ->value($this->query->get('asset_value'))
                        ->readonly()
                        ->style('color: #43494f; width:50%'),
                ]),

                "Scale 5" => Layout::rows([
                    Select::make("confidential_5")
                        ->help('Please select the confidentiality level of the asset (Scale 5).')
                        ->title('Confidentiality')
                        ->options([
                            'Very Low' => 'Very Low',
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                            'Very High' => 'Very High',
                        ])
                        ->value($this->query->get('confidential_5')),
            
                    Select::make("integrity_5")
                        ->help('Please select the integrity level of the asset (Scale 5).')
                        ->title('Integrity')
                        ->options([
                            'Very Low' => 'Very Low',
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                            'Very High' => 'Very High',
                        ])
                        ->value($this->query->get('integrity_5')),
            
                    Select::make("availability_5")
                        ->help('Please select the availability level of the asset (Scale 5).')
                        ->title('Availability')
                        ->options([
                            'Very Low' => 'Very Low',
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                            'Very High' => 'Very High',
                        ])
                        ->value($this->query->get('availability_5')),

                    Input::make('asset_value_5')
                        ->help('This is final result of asset value (Scale 5).')
                        ->title('Asset Value')
                        ->value($this->query->get('asset_value_5'))
                        ->readonly()
                        ->style('color: #43494f; width:50%'),
                ]),
            ]), 
        ];
    }

    /**
     * Update state dynamically based on user input.
     *
     * @param \Orchid\Screen\Repository $repository
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Orchid\Screen\Repository
     */
    public function handle(Repository $repository, Request $request): Repository
    {
        // Retrieve input values directly
        $confidential = $request->input('confidential');
        $integrity = $request->input('integrity');
        $availability = $request->input('availability');

        $confidential_5 = $request->input('confidential_5');
        $integrity_5 = $request->input('integrity_5');
        $availability_5 = $request->input('availability_5');

        // Mapping for numeric totals based on string values
        $mapping = ['Low' => 1, 'Medium' => 2, 'High' => 3];
        $mapping_5 = ['Very Low' => 1, 'Low' => 2, 'Medium' => 3, 'High' => 4, 'Very High' => 5];

        $total_5 = ($mapping_5[$confidential_5] ?? 0) +
                ($mapping_5[$integrity_5] ?? 0) +
                ($mapping_5[$availability_5] ?? 0);

        $assetValue_5 = match (true) {
            $total_5 > 0 && $total_5 <= 4 => 'Very Low',
            $total_5 >= 5 && $total_5 <= 9 => 'Low',
            $total_5 >= 10 && $total_5 <= 14 => 'Medium',
            $total_5 >= 15 && $total_5 <= 19 => 'High',
            $total_5 >= 20 && $total_5 <= 25 => 'Very High',
            default => '', // Optional default case
        };

        $total = ($mapping[$confidential] ?? 0) +
                ($mapping[$integrity] ?? 0) +
                ($mapping[$availability] ?? 0);

        // Determine asset value based on total
        $assetValue = match (true) {
            $total > 0 && $total <= 2 => 'Low',
            $total >= 3 && $total <= 5 => 'Medium',
            $total >= 6 && $total <= 9 => 'High',
            default => '', // Optional default case
        };



        // Set values in the repository
        return $repository->set('asset_value', $assetValue)
            ->set('confidential', $confidential)
            ->set('integrity', $integrity)
            ->set('availability', $availability)
            ->set('confidential_5', $confidential_5)
            ->set('integrity_5', $integrity_5)
            ->set('availability_5', $availability_5)
            ->set('asset_value_5', $assetValue_5)
            ->set('depend_on', $request->input('depend_on'))
            ->set('depended_asset', $request->input('depended_asset'));
    }
}
