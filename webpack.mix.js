const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/* Orchid mix config start */

mix

    .js('resources/js/custom.js', 'public/js')
    .css('resources/css/custom.css', 'public/css')
    .version(); // Use versioning to cache-bust files in production


/* Orchid mix config end */
