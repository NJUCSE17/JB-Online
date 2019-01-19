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

mix.sass('resources/assets/sass/app.scss', 'css/app.css')
    .js('resources/assets/js/app.js', 'js/app.js');

if (mix.inProduction() || process.env.npm_lifecycle_event !== 'hot') {
    mix.version();
}
