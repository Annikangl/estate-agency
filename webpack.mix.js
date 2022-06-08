const mix = require('laravel-mix');
let webpack = require('webpack');
let path = require('path');

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

mix.webpackConfig({
    resolve: {
        alias: { jQuery: path.resolve(__dirname, 'node_modules/jquery/dist/jquery.js') }
    }
});

mix.setPublicPath('public/assets')
    .setResourceRoot('/assets/')
    .js('resources/js/app.js', 'js')
    .sass('resources/sass/app.scss', 'css')
    .version();

mix.webpackConfig({
    plugins: [
        new webpack.IgnorePlugin({
            resourceRegExp: /^jQuery$/
        })
    ]
});


