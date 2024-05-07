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

mix.styles([
    'public/admin/vendor/bootstrap/css/bootstrap.min.css',
    'public/admin/css/volt.css',
    'public/admin/vendor/apexcharts/apexcharts.css',
    'public/admin/vendor/sweetalert2/sweetalert2.min.css',
    'public/admin/vendor/notyf/notyf.min.css',
    'public/admin/vendor/fontawesome-free/css/all.min.css',
    'public/admin/vendor/datatables/datatables.min.css',
    'public/vendor/select2/dist/css/select2.min.css',
    'public/admin/css/app.css',
], 'public/css/admin.css');

mix.scripts([
    'public/admin/vendor/jquery/jquery.min.js',
    'public/admin/vendor/bootstrap/js/bootstrap.min.js',
    'public/vendor/popper/popper.min.js',
    'public/admin/assets/js/volt.js',
    'public/admin/assets/js/on-screen.umd.min.js',
    'public/admin/assets/js/nouislider.min.js',
    'public/admin/assets/js/smooth-scroll.polyfills.min.js',
    'public/admin/vendor/apexcharts/apexcharts.min.js',
    'public/admin/assets/js/chartist.min.js',
    'public/admin/assets/js/chartist-plugin-tooltip.min.js',
    'public/admin/assets/js/sweetalert2.all.min.js',
    'public/admin/vendor/notyf/notyf.min.js',
    'public/admin/assets/js/simplebar.min.js',
    'public/admin/vendor/datatables/datatables.min.js',
    'public/vendor/select2/dist/js/select2.min.js',
], 'public/js/admin.js');

mix.styles([
    'public/admin/vendor/apexcharts/apexcharts.css',
    'public/admin/vendor/sweetalert2/sweetalert2.min.css',
    'public/admin/vendor/notyf/notyf.min.css',
    'public/admin/vendor/fontawesome-free/css/all.min.css',
    'public/admin/vendor/datatables/datatables.min.css',
    'public/vendor/select2/dist/css/select2.min.css',
    'public/admin/css/app.css',
], 'public/css/app.css');

mix.scripts([
    'public/admin/vendor/jquery/jquery.min.js',
    'public/admin/assets/js/on-screen.umd.min.js',
    'public/admin/assets/js/nouislider.min.js',
    'public/admin/assets/js/smooth-scroll.polyfills.min.js',
    'public/admin/vendor/apexcharts/apexcharts.min.js',
    'public/admin/assets/js/chartist.min.js',
    'public/admin/assets/js/chartist-plugin-tooltip.min.js',
    'public/admin/assets/js/sweetalert2.all.min.js',
    'public/admin/vendor/notyf/notyf.min.js',
    'public/admin/assets/js/simplebar.min.js',
    'public/admin/vendor/datatables/datatables.min.js',
    'public/vendor/select2/dist/js/select2.min.js',
], 'public/js/app.js');

mix.styles([
    'public/vendor/tailwind/tailwind.min.css',
    'public/vendor/owl-carousel/owl.carousel.min.css',
    'public/vendor/font-awesome/css/all.min.css',
    'public/vendor/select2/dist/css/select2.min.css',
    'public/css/public-user.css',
], 'public/css/public.css');

mix.scripts([
    'public/vendor/jquery-1/jquery-1.11.3.min.js',
    'public/vendor/alpine/alpine.min.js',
    'public/vendor/select2/dist/js/select2.min.js',
    'public/js/jquery.waterwheelCarousel.min.js',
    'public/vendor/owl-carousel/owl.carousel.min.js',
    'public/vendor/popper/popper.min.js',
], 'public/js/public.js');

mix.scripts([
    'public/js/countfect.min.js',
    'public/admin/vendor/highcharts/highmaps.js',
    'public/admin/vendor/highcharts/exporting.js',
    'public/admin/vendor/highcharts/id-all.js',
    'public/admin/vendor/axios.min.js',
], 'public/js/charts.js');
