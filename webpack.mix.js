let mix = require('laravel-mix')
let tailwindcss = require('tailwindcss')
let path = require('path')
let postcssImport = require('postcss-import')

require('./nova.mix')

mix
  .setPublicPath('dist')
  .js('resources/js/tabs.js', 'js')
  .vue({ version: 3 })
  .postCss('resources/css/tabs.css', 'css', [postcssImport(), tailwindcss('tailwind.config.js'),])
  .nova('dkulyk/nova-tabs')
