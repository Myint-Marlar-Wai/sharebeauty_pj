const mix = require('laravel-mix');
require('mix-env-file');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');

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

const appSystem = process.env.APP_SYSTEM;
console.log('App System : ' + appSystem);
console.log('Building Mode: ' + (mix.inProduction() ? 'Production' : 'Development'));


/**
 * All files inside webpack's output.path directory will be removed once, but the
 * directory itself will not be. If using webpack 4+'s default configuration,
 * everything under <PROJECT_DIR>/dist/ will be removed.
 * Use cleanOnceBeforeBuildPatterns to override this behavior.
 *
 * During rebuilds, all webpack assets that are not used anymore
 * will be removed automatically.
 *
 * See `Options and Defaults` for information
 */
const cleanWebpackPlugin = new CleanWebpackPlugin({
    // Simulate the removal of files
    //
    // default: false
    dry: false,

    // Write Logs to Console
    // (Always enabled when dry is true)
    //
    // default: false
    verbose: true,

    // Automatically remove all unused webpack assets on rebuild
    //
    // default: true
    cleanStaleWebpackAssets: true,

    // Do not allow removal of current webpack assets
    //
    // default: true
    protectWebpackAssets: true,

    // **WARNING**
    //
    // Notes for the below options:
    //
    // They are unsafe...so test initially with dry: true.
    //
    // Relative to webpack's output.path directory.
    // If outside of webpack's output.path directory,
    //    use full path. path.join(process.cwd(), 'build/**/*')
    //
    // These options extend del's pattern matching API.
    // See https://github.com/sindresorhus/del#patterns
    //    for pattern matching documentation

    // Removes files once prior to Webpack compilation
    //   Not included in rebuilds (watch mode)
    //
    // Use !negative patterns to exclude files
    //
    // default: ['**/*']
    cleanOnceBeforeBuildPatterns: [
        '**/*',
        '!.htaccess',
        '!favicon.ico',
        '!index.php',
        '!robots.txt',
        //'!static-files*',
        //'!directoryToExclude/**',
    ],
    //cleanOnceBeforeBuildPatterns: [], // disables cleanOnceBeforeBuildPatterns

    // Removes files after every build (including watch mode) that match this pattern.
    // Used for files that are not created directly by Webpack.
    //
    // Use !negative patterns to exclude files
    //
    // default: []
    cleanAfterEveryBuildPatterns: [
        // 'static*.*',
        // '!static1.js',
    ],

    // Allow clean patterns outside of process.cwd()
    //
    // requires dry option to be explicitly set
    //
    // default: false
    dangerouslyAllowCleanPatternsOutsideProject: false,
});

mix.webpackConfig({
    plugins: [
        cleanWebpackPlugin,
    ],
});

const jsCommon = () => {
    // Common
    mix.copyDirectory('resources/js/common/lib', 'public/js/common/lib')
        .js('resources/js/common/password.js', 'public/js/common')
    // .js('resources/js/app.js', 'public/js')
};
const cssCommon = () => {
    // Common
    mix.copyDirectory('resources/css/common', 'public/css/common')
        .copyDirectory('resources/font/fontawesome', 'public/fonts/fontawesome')
        .copyDirectory('resources/images', 'public/images')
        .sass('resources/sass/common/common.sass', 'public/css/common')
};

const jsShop = () => {
    // Shop
    mix.js('resources/js/shop/common.js', 'public/js/shop')
        .js('resources/js/shop/validation.js', 'public/js/shop')
        .js('resources/js/shop/onceCalender.js', 'public/js/shop')
        .js('resources/js/shop/shopCalender.js', 'public/js/shop')
};
const cssShop = () => {
    // Shop
    mix.sass('resources/sass/shop/style.sass', 'public/css/shop')
};

const jsSeller = () => {
    // Seller
    mix.js('resources/js/id/common.js', 'public/js/id')
        .js('resources/js/id/validation.js', 'public/js/id')

    mix.js('resources/js/ec/common.js', 'public/js/ec')
        .js('resources/js/ec/validation.js', 'public/js/ec')
        .js('resources/js/ec/jquery.qrcode.js', 'public/js/ec')
        .js('resources/js/ec/qrcode.js', 'public/js/ec')
        .js('resources/js/ec/customqrcode.js', 'public/js/ec')
};
const cssSeller = () => {
    // Seller
    mix.sass('resources/sass/id/style.sass', 'public/css/id')
        .sass('resources/sass/ec/style.sass', 'public/css/ec')
};

const jsAdmin = () => {
    // Admin
    mix.js('resources/js/admin/common.js', 'public/js/admin')
};
const cssAdmin = () => {
    // Admin
    mix.sass('resources/sass/admin/style.sass', 'public/css/admin')
};





switch (appSystem) {
    case 'shop':
        // ショップ（ユーザー側、買い手側）
        console.log('Building Shop...');
        jsCommon();
        jsShop();
        cssCommon();
        cssShop();
        break;
    case 'seller':
        // ショップ運営（利用者側、売り手側）
        console.log('Building Seller...');
        jsCommon();
        jsSeller();
        cssCommon();
        cssSeller();
        break;
    case 'admin':
        // 管理（会社）
        console.log('Building Admin...');
        jsCommon();
        jsAdmin();
        cssCommon();
        cssAdmin();
        break;
    case 'batch':
        // バッチ処理
        jsCommon();
        cssCommon();
        break;
    case 'all':
        console.log('Building All...');
        console.warn('開発時の一時機能です');
        jsCommon();
        jsShop();
        jsSeller();
        jsAdmin();
        cssCommon();
        cssShop();
        cssSeller();
        cssAdmin();
        break;
    default:
        throw new Error(
            `不明な App System '${appSystem}'.
             次の中から指定してください. (shop, seller, admin, batch, all)`
        );
}

mix.version();

