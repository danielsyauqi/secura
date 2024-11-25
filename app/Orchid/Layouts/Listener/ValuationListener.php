<?php

namespace App\Orchid\Layouts\Listener;


use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Fields\RadioButtons;


class ValuationListener extends Listener
{

    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['asset_value','confidential','integrity','availability'];

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    protected function layouts(): iterable
    {
        return [
            Layout::rows([
                Group::make([
                    RadioButtons::make("confidential")
                        ->title('Confidentiality')
                        ->options([
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                        ])
                        ->value(optional(value: $this->query->get('confidential'))->value()),
            
                    RadioButtons::make("integrity")
                        ->title('Integrity')
                        ->options([
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                        ])
                        ->value(optional($this->query->get('integrity'))->value()),
            
                    RadioButtons::make("availability")
                        ->title('Availability')
                        ->options([
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                        ])
                        ->value(optional($this->query->get('availability'))->value()),
                ]),
                Label::make()
                    ->title('Note:')
                    ->value('Please select each option carefully; it may impact your risk assessment results.')
                    ->style('font-style: italic; color: #6c757d;')
            ]),
            
                Layout::rows([


                    Input::make('asset_value')
                            ->title('Asset Value')
                            ->value($this->query->get('asset_value'))
                            ->readonly()
                            ->style('color: #43494f;')


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
        $confidential = $request->input('confidential', 'Low');
        $integrity = $request->input('integrity', 'Low');
        $availability = $request->input('availability', 'Low');

        // Mapping for numeric totals based on string values
        $mapping = ['Low' => 1, 'Medium' => 2, 'High' => 3];

        $total = ($mapping[$confidential] ?? 0) +
                ($mapping[$integrity] ?? 0) +
                ($mapping[$availability] ?? 0);

        // Determine asset value based on total
        $assetValue = match (true) {
            $total >= 0 && $total <= 3 => 'Low',
            $total >= 4 && $total <= 6 => 'Medium',
            $total >= 7 && $total <= 9 => 'High',
            default => 'Unknown', // Optional default case
        };

        // Set values in the repository
        return $repository->set('asset_value', $assetValue)
            ->set('confidential', $confidential)
            ->set('integrity', $integrity)
            ->set('availability', $availability);
    }
}

