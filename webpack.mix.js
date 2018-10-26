const mix = require('laravel-mix');

// BABEL config
mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ["es2017"], // default = env
                    }
                }
            }
        ]
    },
    devServer: {
        contentBase: path.resolve(__dirname, 'public/js'),
    },
    resolve: {
        modules: [
            path.resolve('./resources/js'),
            path.resolve('./node_modules')
        ]
    },
    output: {
        publicPath: 'http://localhost:8080/'
    }
});
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

mix.js('resources/js/static/dashboard.min.js', 'public/js/company/static');


if (mix.inProduction) {
    if (process.env.npm_lifecycle_event !== 'hot') {
        mix.version();
    }
}
