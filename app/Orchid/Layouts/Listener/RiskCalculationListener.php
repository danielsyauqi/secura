<?php

namespace App\Orchid\Layouts\Listener;

use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Fields\RadioButtons;

class RiskCalculationListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'likelihood', 'impact_level', 'risk_level', 'risk_owner',
        'likelihood_5', 'impact_level_5', 'risk_level_5'
    ];

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    protected function layouts(): iterable
    {
        return [

            Layout::tabs([

                'Scale 3' => Layout::rows([


                    Group::make([
                        Input::make('impact_level')
                            ->title('Impact Level')
                            ->value(optional($this->query->get('impact_level'))->value())
                            ->readonly()
                            ->help('Determine the impact level of the threat.')
                            ->style('color: #43494f;'),

                        Select::make('likelihood')
                            ->title('Likelihood')
                            ->options([
                                'Low' => 'Low',
                                'Medium' => 'Medium',
                                'High' => 'High',
                            ])
                            ->value(optional($this->query->get('likelihood'))->value())
                            ->help('Determine the likelihood of the threat.'),

                        Input::make('risk_level')
                            ->title('Risk Level')
                            ->value(optional($this->query->get('risk_level'))->value())
                            ->readonly()
                            ->help('Determine the risk level of the threat.')
                            ->style('color: #43494f;'),

                        Input::make('risk_owner')
                            ->title('Risk Owner')
                            ->value(optional($this->query->get('risk_owner'))->value())
                            ->help('Determine the risk owner of the threat.'),


                    ]),


                    Button::make(__('Save'))
                    ->icon('save')
                    ->type(Color::PRIMARY)
                    ->method('save'),
                ]),

                'Scale 5 (Optional)' => Layout::rows([

                    Group::make([
                        Input::make('impact_level_5')
                            ->title('Impact Level')
                            ->value(optional($this->query->get('impact_level_5'))->value())
                            ->readonly()
                            ->help('Determine the impact level of the threat.')
                            ->style('color: #43494f;'),

                        

                        Select::make('likelihood_5')
                            ->title('Likelihood')
                            ->options([
                                'Very Low' => 'Very Low',
                                'Low' => 'Low',
                                'Medium' => 'Medium',
                                'High' => 'High',
                                'Very High' => 'Very High',
                            ])
                            ->value(optional($this->query->get('likelihood_5'))->value())
                            ->help('Determine the likelihood of the threat.'),

                            Input::make('risk_level_5')
                            ->title('Risk Level')
                            ->value(optional($this->query->get('risk_level_5'))->value())
                            ->readonly()
                            ->help('Determine the risk level of the threat.')
                            ->style('color: #43494f;'),

                        


                    ]),

                    Button::make(__('Save'))
                    ->icon('save')
                    ->type(Color::PRIMARY)
                    ->method('save'),
                ]),
            ]),
      
        ];
    }

    /**
     * Update state dynamically based on user input.
     *
     * @param Repository $repository
     * @param Request $request
     *
     * @return Repository
     */
    public function handle(Repository $repository, Request $request): Repository
    {
        $likelihood = $request->input('likelihood');
        $impactLevel = $request->input('impact_level');
        $riskOwner = $request->input('risk_owner');

        $mapping = ['Low' => 1, 'Medium' => 2, 'High' => 3];
        $total = ($mapping[$likelihood] ?? 0) * ($mapping[$impactLevel] ?? 0);

        $risk_level = match (true) {
            $total > 0 && $total <= 2 => 'Low',
            $total >= 3 && $total <= 5 => 'Medium',
            $total >= 6 && $total <= 9 => 'High',
            default => '', // Optional default case
        };

        $likelihood_5 = $request->input('likelihood_5');
        $impactLevel_5 = $request->input('impact_level_5');
        $mapping_5 = ['Very Low' => 1, 'Low' => 2, 'Medium' => 3, 'High' => 4, 'Very High' => 5];
        $total_5 = ($mapping_5[$likelihood_5] ?? 0) * ($mapping_5[$impactLevel_5] ?? 0);

        $risk_level_5 = match (true) {
            $total_5 > 0 && $total_5 <= 4 => 'Very Low',
            $total_5 >= 5 && $total_5 <= 9 => 'Low',
            $total_5 >= 10 && $total_5 <= 14 => 'Medium',
            $total_5 >= 15 && $total_5 <= 19 => 'High',
            $total_5 >= 20 && $total_5 <= 25 => 'Very High',
            default => '', // Optional default case
        };

        Log::info($likelihood_5);

        return $repository
            ->set('impact_level', $impactLevel)
            ->set('likelihood', $likelihood)
            ->set('risk_level', $risk_level)
            ->set('risk_owner', $riskOwner)
            ->set('likelihood_5', $likelihood_5)
            ->set('risk_level_5', $risk_level_5);
    }
}
