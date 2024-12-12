@push('head')
    <meta name="robots" content="noindex"/>
    <meta name="google" content="notranslate">
    <link
          href="/default-logo.png"
          sizes="any"
          type="image/svg+xml"
          id="favicon"
          rel="icon"
    >

    <!-- For Safari on iOS -->
    <meta name="theme-color" content="#21252a">
@endpush

<div class="h2 d-flex flex-column align-items-center">
    @auth
        <x-orchid-icon path="bs.house" class="d-inline d-xl-none"/>
    @endauth

    <!-- Logo Image -->
    <img
        src="/default-logo.png"
        alt="Nuklear Malaysia Logo"
        class="img-fluid mb-2"
        style="width: 180px; height: auto; display: block; margin: 0 auto;"
    >

    <!-- App Name Text -->
    <p class="mt-2 text-center app-name">
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
        margin-top: 15px; /* Adjust spacing below the image */
    }
</style>
