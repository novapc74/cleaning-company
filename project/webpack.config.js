const Encore = require('@symfony/webpack-encore');
const SpritePlugin = require('svg-sprite-loader/plugin');
const path = require('path');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .copyFiles([
        {from: './node_modules/ckeditor4/', to: 'ckeditor/[path][name].[ext]', pattern: /\.(js|css)$/, includeSubdirectories: false},
        {from: './node_modules/ckeditor4/adapters', to: 'ckeditor/adapters/[path][name].[ext]'},
        {from: './node_modules/ckeditor4/lang', to: 'ckeditor/lang/[path][name].[ext]'},
        {from: './node_modules/ckeditor4/plugins', to: 'ckeditor/plugins/[path][name].[ext]'},
        {from: './node_modules/ckeditor4/skins', to: 'ckeditor/skins/[path][name].[ext]'},
        {from: './node_modules/ckeditor4/vendor', to: 'ckeditor/vendor/[path][name].[ext]'}
    ])
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/app.js')
    // .addEntry('admin', './assets/admin.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
        config.debug = true;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    .configureLoaderRule('images', (loaderRule) => {
        loaderRule.exclude = [
            path.resolve(__dirname, 'assets/app/src/images/svg')
        ]; // new line
    })

    .addLoader({
        test: /\.(svg)$/,
        include: [
            path.resolve(__dirname, 'assets/app/src/images/svg'),
        ],
        use: [
            {
                loader: 'svg-sprite-loader', options: {
                    exclude: path.resolve(__dirname, 'assets/app/src/images/svg'),
                    extract: true,
                    publicPath: 'images/svg/',
                    spriteFilename: svgPath => [path.basename(path.dirname(svgPath)), '[hash]', 'svg'].join('.')
                }
            },
            {
                loader: 'svgo-loader',
                options: {
                    configFile: false,
                    plugins: [
                        {
                            name: 'removeAttrs',
                            params: {
                                attrs: "(fill|stroke)"
                            }
                        }
                    ],
                    name: 'images/[name].[ext]',
                    publicPath: 'images/svg/'
                }
            }
        ]
    })

    .copyFiles({
        from: path.resolve(__dirname, 'assets/app/src/video'),
        to: 'video/[path][name].[hash:8].[ext]'
    })

    .addPlugin(new SpritePlugin({
        plainSprite: true,
        plugins : [
            {
                name: 'removeAttrs',
                params: {
                    attrs: "(fill|stroke)"
                }
            }
        ],
        spriteAttrs: {
            id:'',
            fill: '',
            stroke: '',
        }
    }))


// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use React
//.enableReactPreset()

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
//.enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
