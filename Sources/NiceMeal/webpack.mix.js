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

// Common
mix.copyDirectory('resources/assets/common/img', 'public/common-assets/img')
    .copyDirectory('resources/assets/common/js', 'public/common-assets/js');


// Admin
mix.js('resources/assets/admin/js/app.js', 'public/admin-assets/js')
    .babel([
        'resources/assets/admin/js/vendors/bootstrap-datepicker.js',
        'resources/assets/admin/js/vendors/bootstrap-datepicker.ja.js',
        'resources/assets/admin/js/vendors/bootstrap-datepicker.vi.js',
        'resources/assets/admin/js/common.js',
        'resources/assets/admin/js/dashboard.js'
    ], 'public/admin-assets/js/admin.js')
    .copyDirectory('resources/assets/admin/js/pages', 'public/admin-assets/js/pages')
    .sass('resources/assets/admin/sass/app.scss', 'public/admin-assets/css')
    .copyDirectory('resources/assets/admin/img', 'public/admin-assets/img')
    .copy('resources/assets/admin/css/summernote/summernote-ext-faicon.css', 'public/admin-assets/css/summernote')
    .copy('resources/assets/admin/js/summernote/summernote-ext-faicon.js', 'public/admin-assets/js/summernote');

// B2C
mix.copyDirectory('resources/assets/b2c/js', 'public/b2c-assets/js')
    .copy('resources/assets/b2c/css/themes.css', 'public/b2c-assets/css/themes.css')
    .copy('resources/assets/b2c/css/d16fbfb1.app.css', 'public/b2c-assets/css/d16fbfb1.app.css')
    .copy('resources/assets/b2c/css/toastr.css', 'public/b2c-assets/css/toastr.css')
    .copy('resources/assets/b2c/css/jquery.multiselect.css', 'public/b2c-assets/css/jquery.multiselect.css')
    .copy('resources/assets/b2c/css/bootstrap-timepicker.min.css', 'public/b2c-assets/css/bootstrap-timepicker.min.css')
    .copy('resources/assets/b2c/css/owl.carousel.css', 'public/b2c-assets/css/owl.carousel.css')
    .sass('resources/assets/b2c/css/main.scss', 'public/b2c-assets/css/main.css')
    .sass('resources/assets/b2c/css/usercustom.scss', 'public/b2c-assets/css/usercustom.css')
    .sass('resources/assets/b2c/css/login.scss', 'public/b2c-assets/css/login.css')
    .sass('resources/assets/b2c/css/popup.scss', 'public/b2c-assets/css/popup.css')
    .copyDirectory('resources/assets/b2c/css/fonts', 'public/b2c-assets/css/fonts')
    .copyDirectory('resources/assets/b2c/img', 'public/b2c-assets/img')
    .copyDirectory('resources/assets/b2c/vendors', 'public/b2c-assets/vendors')
    .copy('node_modules/font-awesome/fonts/*', 'public/b2c-assets/fonts');

mix.version();
