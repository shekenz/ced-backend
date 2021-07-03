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

// Javascript compilations --------------------------------

// Main JS (Shared)
mix.js('resources/js/index.js', 'public/js'); // Main frontend script available in all index-layout
mix.js('resources/js/app.js', 'public/js'); // Main backend script available in all app-layout

// App JS (Backend)
mix.js('resources/js/ondemand/app/settings.js', 'public/js'); // Loaded on settings view
mix.js('resources/js/ondemand/app/media-optimized.js', 'public/js'); // Loaded on display media view
mix.js('resources/js/ondemand/app/media-library-dragdrop.js', 'public/js'); // Loaded on display media view
mix.js('resources/js/ondemand/app/order-ship.js', 'public/js'); // Loaded on display order view

//  Index JS (Frontend)
mix.js('resources/js/ondemand/index/cart.js', 'public/js'); // Cart script for ajax requests.
mix.js('resources/js/ondemand/index/add-to-cart.js', 'public/js'); // "Add to cart" script on main index.
mix.js('resources/js/ondemand/index/paypal-checkout.js', 'public/js'); // "Add to cart" script on main index.
mix.js('resources/js/ondemand/index/user-menu.js', 'public/js'); // Loaded on index-layout when user is authenticated
mix.js('resources/js/ondemand/index/glide.js', 'public/js'); // Index caroussel, loaded on index view 
//mix.js('resources/js/ondemand/index/shipping-form.js', 'public/js'); // Loaded on shipping form view


// CSS compilations ---------------------------------------

// App CSS (Backend)
mix.postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);

// Index CSS (Frontend)
mix.postCss('resources/css/index.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
])

// Move imgages
mix.copyDirectory('resources/img', 'public/img');
mix.copyDirectory('resources/fonts', 'public/fonts');


// Miscellaneous configs ----------------------------------

// Cache bustin'
if (mix.inProduction()) {
    mix.version();
}

mix.webpackConfig({
    stats: 'errors-warnings'
});

// Notifications off
mix.disableSuccessNotifications();