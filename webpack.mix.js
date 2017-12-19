let mix = require('laravel-mix');

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
// mix.copy('resources/assets/sass/_custom.scss', 'vendor/twbs/bootstrap/scss/_custom.scss');  
// mix.copy('resources/assets/sass/bootstrap.scss', 'vendor/twbs/bootstrap/scss/bootstrap.scss');
mix.copy('node_modules/font-awesome/fonts', 'public/fonts');
mix.sass('resources/assets/sass/app.scss', 'public/css')
   .js('resources/assets/js/app.js', 'public/js');
mix.scripts([
    'public/js/app.js',
    'public/js/discussion.js',
    'public/js/likes.js',
    'public/js/badges.js'
], 'public/js/all.js').version();

