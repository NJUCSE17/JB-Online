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

mix.setPublicPath('public');

mix.js('resources/assets/js/app.js', 'js/app.js')
    .sass('resources/assets/sass/app-light.scss', 'css/app-light.css')
    .sass('resources/assets/sass/app-dark.scss', 'css/app-dark.css');

if (mix.inProduction() || process.env.npm_lifecycle_event !== 'hot') {
    mix.version();
}
