<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <a href="{{ route(config('platform.profile', 'platform.profile')) }}" class="col-10 d-flex align-items-center me-3">
                @if($image = Auth::user()->presenter()->image())
                    <img src="{{$image}}" alt="{{ Auth::user()->presenter()->title()}}" class="thumb-sm avatar b me-3" type="image/*" style="border-radius: 50%; width: 100px; height: 100px;">
                @else
                    <p>No image available</p>
                @endif
                <p>Image URL: {{ $image }}</p> <!-- Debug statement -->
                <p>User: {{ Auth::user() }}</p> <!-- Debug statement -->
            </a>
        </div>
    </div>
</div>