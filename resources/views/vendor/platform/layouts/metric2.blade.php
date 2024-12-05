<style>
    .image {
        position: absolute;
        font-size: 50px; /* Set the font-size for large icon */
        top: 10px; /* Adjust top position to not overflow */
        right: 10px; /* Align icon to the right */
        color: #333; /* Change icon color */
        opacity: 0.1; /* Set opacity */
    }

    .metric-container {
        position: relative; /* Make the container the reference for positioning */
        overflow: hidden; /* Prevent the icon from overflowing outside the box */
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
        $colors = ['eaf4ff','ffffea','ffeaea','eaffea'];  // Array of colors
        $icons = ['bi-archive-fill', 'bi-shield-fill-exclamation', 'bi-file-earmark-ruled-fill', 'bi-person-fill'];  // Array of Bootstrap icons
        $index = 0;
    @endphp

    <div class="row mb-2 g-3 g-mb-4">
        @foreach($metrics as $key => $metric)
            <div class="col">
                <div class="p-4 rounded shadow-sm h-100 d-flex flex-column metric-container" style="background-color: #{{$colors[$index]}}">
                    <small class="text-muted d-block mb-1">{{ __($key) }}</small>
                    <p class="h3 text-black fw-light mt-auto">
                        {{ is_array($metric) ? $metric['value'] : $metric }}
                    </p>
                    
                    <!-- Bootstrap Icon as Overlay -->
                    <i class="bi {{ $icons[$index] }} image"></i> <!-- Render the icon based on the index -->
                </div>
            </div>
            @php
            ++$index;
            @endphp
        @endforeach
    </div>
</div>
