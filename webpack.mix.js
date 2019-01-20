let mix = require('laravel-mix')

mix.setPublicPath('dist')
   .js('resources/js/tabs.js', 'js')
   .sass('resources/sass/tabs.scss', 'css')
