<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Dashboard;

use Orchid\Screen\Layouts\Chart;

class RiskLevelChart extends Chart
{
    /**
     * Height of the chart.
     *
     * @var int
     */
    protected $height = 300;

    protected $export = true;

    protected $colors = [
        '#0080ff',
        '#e6e600',
        '#b00000',
    ];

    protected $type = self::TYPE_PIE;
}
