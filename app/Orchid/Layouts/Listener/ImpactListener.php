<?php

namespace App\Orchid\Layouts\Listener;

use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Layouts\Listener;
use App\Models\Assessment\Valuation;
use Orchid\Screen\Fields\RadioButtons;


class ImpactListener extends Listener
{

    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['business_loss','impact_level','asset_value','business_loss_5','impact_level_5','asset_value_5'];

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

                    Group::make([

                        Input::make("asset_value")
                        ->title('Asset Value')
                        ->disabled()
                        ->value(optional($this->query->get('asset_value'))->value())
                        ->help('Please refer from this asset value.')
                        ->style('color: #43494f; width:50%'),
    
    
                        Select::make("business_loss")
                        ->title('Business Loss')
                        ->style('width:50%')
                        ->options([
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                        ])
                        ->value(optional($this->query->get('business_loss'))->value())
                        ->help('Determine the business loss.'),

        
                    ]),

                    Group::make([
                        Input::make("impact_level")
                        ->title('Impact')
                        ->style('color: #43494f; width:50%')
                        ->readonly()
                        ->value(optional( $this->query->get('impact_level'))->value())
                        ->help('Determine the business loss.'),

                        
                    Button::make(__('Save'))
                    ->icon('save')
                    ->type(Color::PRIMARY)
                    ->method('save'),

                      
                    ]),

                ]),


                    'Scale 5 (Optional)' => Layout::rows([

                        Group::make([
    
                    Input::make("asset_value_5")
                        ->title('Asset Value (Scale 5)')
                        ->disabled()
                        ->value(optional($this->query->get('asset_value_5'))->value())
                        ->help('Please refer from this asset value.')
                        ->style('color: #43494f; width:50%'),
    
    
                    Select::make("business_loss_5")
                    ->style('width:50%')
                    ->title('Business Loss (Scale 5)')
                    ->options([
                        'Very Low' => ' Very Low',
                        'Low' => 'Low',
                        'Medium' => 'Medium',
                        'High' => 'High',
                        'Very High' => 'Very High',
                    ])
                    ->value(optional($this->query->get('business_loss_5'))->value())
                    ->help('Determine the business loss.'),

                ]),

                Group::make([
    
                    Input::make("impact_level_5")
                    ->title('Impact (Scale 5)')
                    ->style('color: #43494f; width:50%')
                    ->options([
                        'Very Low' => ' Very Low',
                        'Low' => 'Low',
                        'Medium' => 'Medium',
                        'High' => 'High',
                        'Very High' => 'Very High',
                    ])
                    ->readonly()
                    ->value(optional( $this->query->get('impact_level_5'))->value())
                    ->help('Determine the impact level.'),

                    Button::make(__('Save'))
                    ->icon('save')
                    ->type(Color::PRIMARY)
                    ->method('save'),

                ]),
     
                    
                
                ]),

            ]),
            

            

        ];
    }

    /**
     * Update state dynamically based on user input.
     *
     * @param Repository $repository
     * @param Request  $request
     *
     * @return Repository
     */
    public function handle(Repository $repository, Request $request): Repository
    {
        // Retrieve input values directly
        $business_loss = $request->input('business_loss');
        $assetID = $repository->get('assetID');
        $asset_value = Valuation::where('asset_id', $assetID)->pluck('asset_value')->first();

        // Mapping for numeric totals based on string values
        $mapping = ['Low' => 1, 'Medium' => 2, 'High' => 3];

        $total = ($mapping[$business_loss] ?? 0) *
                ($mapping[$asset_value] ?? 0) ;
        // Determine asset value based on total
        $impact_level = match (true) {
            $total > 0 && $total <= 2 => 'Low',
            $total >= 3 && $total <= 5 => 'Medium',
            $total >= 6 && $total <= 9 => 'High',
            default => '', // Optional default case
        };

        // Retrieve input values directly for scale 5
        $asset_value_5 = Valuation::where('asset_id', $assetID)->pluck('asset_value_5')->first();
        $business_loss_5 = $request->input('business_loss_5');

        // Mapping for numeric totals based on string values for scale 5
        $mapping_5 = ['Very Low' => 1, 'Low' => 2, 'Medium' => 3, 'High' => 4, 'Very High' => 5];

        $total_5 = ($mapping_5[$business_loss_5] ?? 0) *
               ($mapping_5[$asset_value_5] ?? 0);

        // Determine asset value based on total for scale 5
        $impact_level_5 = match (true) {
            $total_5 > 0 && $total_5 <= 4 => 'Very Low',
            $total_5 >= 5 && $total_5 <= 9 => 'Low',
            $total_5 >= 10 && $total_5 <= 14 => 'Medium',
            $total_5 >= 15 && $total_5 <= 19 => 'High',
            $total_5 >= 20 && $total_5 <= 25 => 'Very High',
            default => '', // Optional default case
        };

        log::info($asset_value_5);

        // Set values in the repository
        return $repository
            ->set('impact_level', $impact_level)
            ->set('business_loss', $business_loss)
            ->set('impact_level_5', $impact_level_5)
            ->set('business_loss_5', $business_loss_5)
            ->set('asset_value', $asset_value)
            ->set('asset_value_5', $asset_value_5);
    }
}

