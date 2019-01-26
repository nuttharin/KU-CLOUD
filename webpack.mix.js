const mix = require('laravel-mix');

// BABEL config
mix.webpackConfig({
    module: {
        rules: [{
            test: /\.jsx?$/,
            exclude: /node_modules/,
            use: {
                loader: 'babel-loader',
                options: {
                    presets: ["es2017"], // default = env
                }
            }
        }]
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

mix.js('resources/js/company/static/dashboard.min.js', 'public/js/company/static')
    .js('resources/js/company/static/staticDataTable.min.js', 'public/js/company/static')
    // .js('resources/js/app.js', 'public/js/app.js')
    // .js('resources/js/containers/company/Accounts/Accounts.js', 'public/js/company/account')
    .js('resources/js/lib/TableEx.min.js', 'public/js/lib/TableEx.min.js')

    .js('resources/js/account/account.min.js', 'public/js/company/account')
    .js('resources/js/account/register.min.js', 'public/js/account/')
    .js('resources/js/company/static/dashboard.min.js', 'public/js/admin/static')
    .js('resources/js/company/users/users.min.js', 'public/js/company/users')
    .js('resources/js/company/customer/customer.min.js', 'public/js/company/customer')
    .js('resources/js/ManagementUsers.js', 'public/js/ManagementUsers.js')

    //AdminUser
    .js('resources/js/admin/Users/AdminUser.min.js', 'public/js/admin/Users/AdminUser.min.js')
    .js('resources/js/admin/Users/CompanyUser.min.js', 'public/js/admin/Users/CompanyUser.min.js')
    .js('resources/js/admin/Users/CustomerUser.min.js', 'public/js/admin/Users/CustomerUser.min.js')
    .js('resources/js/ManagementAdminUsers.min.js', 'public/js/ManagementAdminUsers.min.js')

    .js('resources/js/admin/Infographic/infographicDataTable.min.js', 'public/js/admin/Infographic/infographicDataTable.min.js');

// if (mix.inProduction) {
//     if (process.env.npm_lifecycle_event !== 'hot') {
//         mix.version();
//     }
// }
// mix.browserSync('http://localhost:8000');


if (mix.inProduction()) {
    mix.version();
}
