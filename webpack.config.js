var Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    // the project directory where all compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()
    // allow sass/scss files to be processed
    .enableSassLoader()
    // create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(false)
    //.createSharedEntry('js/common', ['jquery'])
    // will create public/build/app.js and public/build/app.css
    .addEntry('js/purchase', './assets/js/purchase.js')
    .addEntry('js/jquery-3.3.1', './assets/js/jquery-3.3.1.js')
    .addStyleEntry('css/breadcrumbs', ['./assets/css/breadcrumbs.css'])
    .addStyleEntry('css/nav', ['./assets/css/nav.min.css'])
    .addStyleEntry('css/fromagerie', ['./assets/scss/fromagerie.scss'])
    .addPlugin(new CopyWebpackPlugin([
        // copies to {output}/static
        { from: './assets/images', to: 'images' },
        { from: './assets/uploads', to: 'uploads' },
        { from: './assets/bundles', to: 'bundles'}
    ]))
;

module.exports = Encore.getWebpackConfig();
