const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/index.js', 'public/js');
mix.js('resources/js/media.js', 'public/js');
mix.postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);
mix.postCss('resources/css/index.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer')({
        grid: 'autoplace'
    }),
])

mix.webpackConfig({
    stats: 'errors-warnings'
});

mix.copyDirectory('resources/img', 'public/img');
mix.copyDirectory('resources/fonts', 'public/fonts');

// Cache bustin'
if (mix.inProduction()) {
    mix.version();
}