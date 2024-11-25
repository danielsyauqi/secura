<?php

namespace App\Orchid\Layouts\Listener;

use App\Models\Assessment\Valuation;
use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Fields\RadioButtons;


class ImpactListener extends Listener
{

    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['business_loss','impact_level','asset_value'];

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    protected function layouts(): iterable
    {
        return [
            Layout::rows([

                
                RadioButtons::make("business_loss")
                ->title('Business Loss')
                ->options([
                    'Low' => 'Low',
                    'Medium' => 'Medium',
                    'High' => 'High',
                ])
                ->value(optional(value: $this->query->get('business_loss'))->value())
                ->help('Determine the business loss.'),

            Input::make("impact_level")
                ->title('Impact Level')
                ->value($this->query->get('impact_level'))
                ->help('Determine the impact level.')
                ->disabled()
                ->style('color: #43494f;'),

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
        $business_loss = $request->input('business_loss', 'Low');
        $assetID = $repository->get('assetID');
        $asset_value = Valuation::where('asset_id', $assetID)->pluck('asset_value')->first();

        // Mapping for numeric totals based on string values
        $mapping = ['Low' => 1, 'Medium' => 2, 'High' => 3];

        $total = ($mapping[$business_loss] ?? 0) *
                ($mapping[$asset_value] ?? 0) ;
        // Determine asset value based on total
        $impact_level = match (true) {
            $total >= 0 && $total <= 3 => 'Low',
            $total >= 4 && $total <= 6 => 'Medium',
            $total >= 7 && $total <= 9 => 'High',
            default => 'Unknown', // Optional default case
        };

        // Set values in the repository
        return $repository
            ->set('business_loss', $business_loss)
            ->set('impact_level', $impact_level);
    }
}

