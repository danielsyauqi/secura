<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Dashboard;

use Orchid\Screen\Layouts\Chart;

class AssetTypeChart extends Chart
{
    /**
     * Height of the chart.
     *
     * @var int
     */
    protected $height = 300;

    protected $export = true;
        
    protected $template = 'platform::layouts.barChart';


    protected $type = self::TYPE_BAR;
}
