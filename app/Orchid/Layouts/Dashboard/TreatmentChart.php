<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Dashboard;

use Orchid\Screen\Layouts\Chart;

class TreatmentChart extends Chart
{
    /**
     * Height of the chart.
     *
     * @var int
     */
    protected $height = 300;

    protected $export = true;


    /**
     * Configuring line.
     *
     * @var array
     */
    protected $lineOptions = [
        'spline'     => 1,
        'regionFill' => 1,
        'hideDots'   => 0,
        'hideLine'   => 0,
        'heatline'   => 0,
        'dotSize'    => 5,
    ];

    protected $colors = [
        '#400080',  ];

    
}
