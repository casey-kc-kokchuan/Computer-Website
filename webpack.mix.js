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

mix.js('resources/js/app.js', 'public/js')
	.scripts('resources/js/utility.js', 'public/js/utility.js')
	.scripts('resources/js/ShoppingCart.js', 'public/js/ShoppingCart.js')
	.scripts('resources/js/OrderManager.js' , 'public/js/OrderManager.js')
	.scripts('resources/js/Account.js' , 'public/jsAccount.js')
	.scripts('resources/js/ProductManager.js' , 'public/js/ProductManager.js')
    .styles([
    	'resources/css/all.css',
    	'resources/css/RWD_max991.css',
    	'resources/css/RWD_992to1210.css'], 'public/css/all.css')
