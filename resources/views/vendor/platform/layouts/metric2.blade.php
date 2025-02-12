<style>
    .metric-container {
        position: relative;
        overflow: hidden;
    }
    
    .metric-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        color: #333;
        opacity: 0.1;
    }
    
    .metric-value {
        font-size: 1.75rem;
        font-weight: 300;
        line-height: 1.2;
        color: #000;
    }
    
    .metric-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="mb-3">
    @isset($title)
        <legend class="text-black px-4 mb-0">
            {{ __($title) }}
        </legend>
    @endisset

    @php
        $metricClasses = [
            'Asset Registered' => [
                'bg-color' => 'eaf4ff',
                'icon' => 'bi-archive-fill',
                'font-size' => '30px'
            ],
            'Current Threats' => [
                'bg-color' => 'ffffea',
                'icon' => 'bi-shield-fill-exclamation',
                'font-size' => '40px'
            ],
            'Uncompleted RA' => [
                'bg-color' => 'ffeaea',
                'icon' => 'bi-file-earmark-ruled-fill',
                'font-size' => '35px'
            ],
            'Total Team Members' => [
                'bg-color' => 'eaffea',
                'icon' => 'bi-person-fill',
                'font-size' => '45px'
            ]
        ];
    @endphp

    <div class="row mb-2 g-3 g-mb-4">
        @foreach($metrics as $key => $metric)
            @php
                $config = $metricClasses[$key] ?? [
                    'bg-color' => 'ffffff',
                    'icon' => 'bi-graph-up',
                    'font-size' => '35px'
                ];
            @endphp
            <div class="col">
                <div class="p-4 rounded shadow-sm h-100 d-flex flex-column metric-container" 
                     style="background-color: #{{ $config['bg-color'] }}">
                    <small class="metric-label">{{ __($key) }}</small>
                    <p class="metric-value mt-auto">
                        {{ is_array($metric) ? $metric['value'] : $metric }}
                    </p>
                    <i class="bi {{ $config['icon'] }} metric-icon" 
                       style="font-size: {{ $config['font-size'] }}"></i>
                </div>
            </div>
        @endforeach
    </div>
</div>
