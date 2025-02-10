<?php

namespace App\Orchid\Layouts\Listener\Bulk;

use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;


class TreatmentBulk extends Listener
{


    protected $targets = ['start_date', 'end_date', 'personnel', 'residual_risk', 'residual_risk_5' ];

    protected function layouts(): iterable
    {

        return [
            
            
            Layout::rows([

                Input::make('start_date')
                    ->type('date')
                    ->title('Start Date')
                    ->help('The date when the treatment plan starts. ')
                    ->placeholder('YYYY-MM-DD'),

                Input::make('end_date')
                    ->type('date')
                    ->title('End Date')
                    ->help('The date when the treatment plan ends.')
                    ->placeholder('YYYY-MM-DD'),


                  
                    Input::make('personnel')
                        ->title('Personnel')
                        ->help('Include professionals with expertise in security, ICT, and the organization’s core business operations.'),
                        
                    Select::make("residual_risk")
                        ->title('Residual Risk')
                        ->help('Determine the residual risk.')
                        ->options([
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                        ]),

                    Select::make("residual_risk_5")
                        ->title('Residual Risk (Scale 5 Optional)')
                        ->help('Determine the residual risk.')
                        ->options([
                            'Very Low' => 'Very Low',
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High',
                            'Very High' => 'Very High',
                        ])

               
            ]),


        ];
    }

    public function handle(Repository $repository, Request $request): Repository
    {
        return $repository;
    }


}
