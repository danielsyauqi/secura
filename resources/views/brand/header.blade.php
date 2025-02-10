@push('head')
    <meta name="robots" content="noindex"/>
    <meta name="google" content="notranslate">
    <link
          href="{{ file_exists(public_path('/favicon.ico')) ? asset('favicon.ico') : asset('default-logo.png') }}"
          sizes="any"
          type="image/svg+xml"
          id="favicon"
          rel="icon"
    >

    <!-- For Safari on iOS -->
    <meta name="theme-color" content="#21252a">
@endpush

<div class="h2 d-flex flex-column align-items-center ">
    @auth
        <x-orchid-icon path="bs.house" class="d-inline d-xl-none"/>
    @endauth

    <!-- Logo Image -->
    <img
        src="{{ file_exists(public_path('/favicon.ico')) ? asset('favicon.ico') : asset('default-logo.png') }}"
        alt=""
        class="img-fluid mb-2 logo-image"
        id="logo-app"
        style="width: 180px; height: auto; display: block; margin: 0 auto;"
    >

    <!-- App Name Text -->
    <p class="mt-2 text-center app-brand" id="name-app"> 
        SecuRA
    </p>
    <p class="text-center app-name" id="name-app"> 

        {{ config('app.name') }}
    </p>
</div>

<style>
    .app-name {
        font-family: 'Poppins', sans-serif; /* Custom font */
        font-weight: 600; /* Makes the text slightly bold */
        font-size: 1rem; /* Adjust size as needed */
        color: #6c757d; /* Neutral dark color */
        letter-spacing: 0.05rem; /* Add slight spacing */
        margin: 0;
    }

    .app-brand{
        margin: 0;
        color: #cbcbcb; /* Neutral dark color */

    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .app-name {
            font-size: 0; /* Smaller font size for mobile */
            margin: 0;
        }

        .logo-image {
            max-width: 0; /* Smaller logo size for mobile */
            margin:0;
           
        }

        #logo-app{
                display:none;
        }

        #name-app{
            display:none;
        
        }
    }

    @media (min-width: 769px) and (max-width: 1200px) {

        .app-name {
            font-size: 0; /* Smaller font size for mobile */
            margin: 0;
        }

        .logo-image {
            max-width: 0; /* Smaller logo size for mobile */
            margin:0;
           
        }

        #logo-app{
                display:none;
        }

        #name-app{
            display:none;
        
        }
    }
</style>
