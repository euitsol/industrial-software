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

mix.styles([
    'public/assets/vendor/bootstrap/css/bootstrap.min.css',
    'public/assets/vendor/fontawesome/css/all.css',
    'public/assets/css/orionicons.css',
    'public/assets/css/style.default.css',
    'public/assets/css/custom.css'
], 'public/css/institute.css').version();

mix.scripts([
    'public/assets/vendor/jquery/jquery.min.js',
    'public/assets/vendor/popper.js/umd/popper.min.js',
    'public/assets/vendor/bootstrap/js/bootstrap.min.js',
    'public/assets/vendor/jquery.cookie/jquery.cookie.js',
    'public/assets/js/front.js',
], 'public/js/institute.js').version();
