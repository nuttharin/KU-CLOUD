<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('Auth','Api\AuthController@login');

// Route::post('login', 'UserController@authenticate');

Route::get('open', 'DataController@open'); //test

Route::post('account/register', 'Api\AccountsController@register');

Route::post('getAllEmail', 'Api\AuthController@getAllEmail');

Route::group([
    'middleware' => 'api',
    'prefix' => 'address',
], function ($router) {

    Route::get('provinces', 'Api\AddressController@getAllProvinces');
    Route::get('amphures/province/{province_id}', 'Api\AddressController@getAmphuresByProvince');
    Route::get('districts/province/{province_id}/amphure/{amphure_id}', 'Api\AddressController@getDistrictsByAmphures');

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'Auth',
], function ($router) {
    Route::put('ResetPassword', 'Api\AuthController@resetPasswordFirst');
    Route::post('Login', 'Api\AuthController@login');
    Route::post('Logout', 'Api\AuthController@logout');
    Route::post('Refresh', 'Api\AuthController@refresh');
    Route::post('Me', 'Api\AuthController@me');

});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'admin',
], function ($router) {

    Route::get('administer', 'Api\AdminController@getAllAdminister');
    Route::post('administer/create', 'Api\AdminController@createAdminister');
    Route::put('administer/edit', 'Api\AdminController@editAdminister');
    Route::get('webservice/getCompanyID', 'Api\AdminController@getCompanyID');
    Route::get('companies', 'Api\AdminController@getAllCompanies');
    Route::post('company/create', 'Api\AdminController@createCompany');
    Route::put('company/edit', 'Api\AdminController@editCompany');

    Route::get('customers', 'Api\AdminController@getAllCustomers');
    Route::post('customer/create', 'Api\AdminController@createCustomer');
    Route::put('customer/edit', 'Api\AdminController@editCustomer');

    Route::get('companydata', 'Api\AdminController@getAllCompanyData');
    Route::post('companydata/create', 'Api\AdminController@createCompanyData');
    Route::put('companydata/edit', 'Api\AdminController@editCompanyData');
    Route::delete('companydata/delete', 'Api\AdminController@deleteCompanyData');

    Route::put('users/block', 'Api\AdminController@blockUser');
    Route::put('users/unblock', 'Api\AdminController@unblockUser');

    Route::delete('users/delete', 'Api\AdminController@deleteUser');

    Route::get('companydata/checkdelete', 'Api\AdminController@getCountUsersByCompanyID');

    Route::get('users/online', 'Api\AdminController@countUserOnline');


    //Static
    Route::get('webservices', 'Api\AdminController@getWebServiceByCompany');
    Route::get('static', 'Api\AdminController@getStaticDashboard');
    Route::post('static', 'Api\AdminController@addStatic');
    Route::delete('static', 'Api\AdminController@deleteStatic');
    Route::get('static/{static_id}', 'Api\AdminController@getStaticDashboardById');
    Route::put('static', 'Api\AdminController@updateStatic');
    Route::put('static/dashboard', 'Api\AdminController@updateStaticDashboard');

    Route::get('staticDatasource', 'Api\AdminController@getDatasourceStatic');
    Route::post('static/datasource', 'Api\AdminController@addDatasourceStatic');
    Route::delete('static/datasource', 'Api\AdminController@deleteDatasourceByStatic');

    Route::get('database/log', 'Api\AdminController@getLogList');
    Route::get('database/log/folder', 'Api\AdminController@getFolderLogs');
    Route::get('database/log/file', 'Api\AdminController@getFileLogByFolder');
    Route::get('database/logfile', 'Api\AdminController@getFileLog');
    Route::post('database/log/file/download', 'Api\AdminController@downloadFileLog');
    Route::delete('database/log/file/delete', 'Api\AdminController@deleteFileLog');

    Route::get('infographic/getInfoByUserID', 'Api\AdminController@getAllInfograpic');
    Route::get('infographic/getInfoByInfoID', 'Api\AdminController@getInfograpicData');
    Route::post('infographic/create', 'Api\AdminController@createInfograpic');
    Route::put('infographic/update', 'Api\AdminController@updateInfograpic');
    Route::put('infographic/updateInfoData', 'Api\AdminController@updateInfograpicData');
    Route::delete('infographic/delete', 'Api\AdminController@deleteInfograpic');

    Route::post('infographic/createDatasource', 'Api\AdminController@addDatasourceInfo');

});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'company',
], function ($router) {
    Route::get('test', 'Api\CompanyController@test'); //test

    Route::get('users', 'Api\CompanyController@getAllUser');
    Route::post('users', 'Api\CompanyController@addUserCompany');
    Route::put('users/block', 'Api\CompanyController@blockUserCompany');
    Route::put('users/edit', 'Api\CompanyController@editUserCompany');
    Route::delete('users/phone', 'Api\CompanyController@deletePhoneUser');
    Route::delete('users/email', 'Api\CompanyController@deleteEmailUser');
    Route::get('users/online', 'Api\CompanyController@countUserOnline');

    Route::get('customers', 'Api\CompanyController@getAllCustomer');
    Route::post('customers', 'Api\CompanyController@addUserCustomer');
    Route::post('customers/company', 'Api\CompanyController@addCustomerInCompany');
    Route::get('customers/email', 'Api\CompanyController@getAllEmailCustomer');

    //Static
    Route::get('static', 'Api\CompanyController@getStaticDashboard');
    Route::post('static', 'Api\CompanyController@addStatic');
    Route::delete('static', 'Api\CompanyController@deleteStatic');
    Route::get('static/{static_id}', 'Api\CompanyController@getStaticDashboardById');
    Route::put('static', 'Api\CompanyController@updateStatic');
    Route::put('static/dashboard', 'Api\CompanyController@updateStaticDashboard');

    Route::get('staticDatasource', 'Api\CompanyController@getDatasourceStatic');
    Route::post('static/datasource', 'Api\CompanyController@addDatasourceStatic');
    Route::delete('static/datasource', 'Api\CompanyController@deleteDatasourceByStatic');

    Route::get('analysis/data', 'Api\Company\AnalysisController@getAllDataAnalysis');
    Route::post('analysis/data', 'Api\Company\AnalysisController@createDataAnalysis');
    Route::post('analysis', 'Api\Company\AnalysisController@analysisProcess');

    Route::get('database/log/file', 'Api\CompanyController@getFileLogByFolder');
    Route::get('database/logfile', 'Api\CompanyController@getFileLog');

});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'customer',
], function ($router) {
    Route::get('companies', 'Api\CustomerController@getCompanyListForCustomer');
    Route::put('companies', 'Api\CustomerController@approveCompany');
});


Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'account',
], function ($router) {
    Route::post('password', 'Api\AccountsController@changePassword');

    Route::get('/', 'Api\AccountsController@getAccount');

    Route::get('profile/{filename}', 'Api\AccountsController@getProfile');
    Route::post('profile', 'Api\AccountsController@uploadProfile');

    Route::put('username', 'Api\AccountsController@updateUsername');

    Route::post('name', 'Api\AccountsController@updateName');

    Route::put('email', 'Api\AccountsController@changePrimaryEmail');
    Route::post('email', 'Api\AccountsController@addEmail');
    Route::delete('email', 'Api\AccountsController@deleteEmail');

    Route::put('phone', 'Api\AccountsController@changePrimaryPhone');
    Route::post('phone', 'Api\AccountsController@addPhone');
    Route::delete('phone', 'Api\AccountsController@deletePhone');
});

Route::group(['middleware' => ['jwt.verify']], function () {

    Route::get('closed', 'DataController@closed'); //test

    //account
    // Route::post('account/password', 'Api\AccountsController@changePassword');

    // Route::get('account', 'Api\AccountsController@getAccount');

    // Route::get('account/profile/{filename}', 'Api\AccountsController@getProfile');
    // Route::post('account/profile', 'Api\AccountsController@uploadProfile');

    // Route::put('account/username', 'Api\AccountsController@updateUsername');

    // Route::post('account/name', 'Api\AccountsController@updateName');

    // Route::put('account/email', 'Api\AccountsController@changePrimaryEmail');
    // Route::post('account/email', 'Api\AccountsController@addEmail');
    // Route::delete('account/email', 'Api\AccountsController@deleteEmail');

    // Route::put('account/phone', 'Api\AccountsController@changePrimaryPhone');
    // Route::post('account/phone', 'Api\AccountsController@addPhone');
    // Route::delete('account/phone', 'Api\AccountsController@deletePhone');

    //Company

    // Route::get('company/users', 'Api\CompanyController@getAllUser');
    // Route::post('company/users', 'Api\CompanyController@addUserCompany');
    // Route::put('company/users/block', 'Api\CompanyController@blockUserCompany');
    // Route::put('company/users/edit', 'Api\CompanyController@editUserCompany');
    // Route::delete('company/users/phone', 'Api\CompanyController@deletePhoneUser');
    // Route::delete('company/users/email', 'Api\CompanyController@deleteEmailUser');
    // Route::get('company/users/online', 'Api\CompanyController@countUserOnline');

    // Route::get('company/customers', 'Api\CompanyController@getAllCustomer');
    // Route::post('company/customers', 'Api\CompanyController@addUserCustomer');
    // Route::post('company/customers/company', 'Api\CompanyController@addCustomerInCompany');
    // Route::get('company/customers/email', 'Api\CompanyController@getAllEmailCustomer');

    // Route::get('company/database/log/file', 'Api\CompanyController@getFileLogByFolder');
    // Route::get('company/database/logfile', 'Api\CompanyController@getFileLog');

    Route::get('company/webservices', 'Api\CompanyController@getWebServiceByCompany');
    Route::get('company/webservicedata', 'Api\CompanyController@getAllWebserviceData');
    Route::post('company/webservice/editRegisWebService', 'Api\CompanyController@editRegisWebService');
    Route::post('company/webservice/addRegisWebService', 'Api\CompanyController@addRegisWebService');
    Route::get('company/webservice/getCompanyID', 'Api\CompanyController@getCompanyID');
    Route::post('company/webservice/deletewebservice', 'Api\CompanyController@deletewebservice');

    Route::get('company/iot/getkeyiot', 'Api\CompanyController@getKeyiot');
    Route::post('company/iot/addRegisIotService','Api\CompanyController@addRegisIotService');

    // Route::get('company/static', 'Api\CompanyController@getStaticDashboard');
    // Route::post('company/static', 'Api\CompanyController@addStatic');
    // Route::get('company/static/{static_id}', 'Api\CompanyController@getStaticDashboardById');
    // Route::put('company/static', 'Api\CompanyController@updateStatic');
    // Route::put('company/static/dashboard', 'Api\CompanyController@updateStaticDashboard');

    // Route::delete('company/static', 'Api\CompanyController@deleteStatic');

    // Route::get('company/staticDatasource', 'Api\CompanyController@getDatasourceStatic');
    // Route::post('company/static/datasource', 'Api\CompanyController@addDatasourceStatic');
    // Route::delete('company/static/datasource', 'Api\CompanyController@deleteDatasourceByStatic');

    // Route::get('company/analysis/data', 'Api\Company\AnalysisController@getAllDataAnalysis');
    // Route::post('company/analysis/data', 'Api\Company\AnalysisController@createDataAnalysis');
    // Route::post('company/analysis', 'Api\Company\AnalysisController@analysisProcess');

    Route::post('company/gettabledw', 'Api\CompanyController@getAllWebserviceData');
    Route::post('company/webservice/downloadJSONFile', 'Api\CompanyController@downloadJSONFile');

    /* Admin */
    // Route::get('admin/administer', 'Api\AdminController@getAllAdminister');
    // Route::post('admin/administer/create', 'Api\AdminController@createAdminister');
    // Route::put('admin/administer/edit', 'Api\AdminController@editAdminister');
    // Route::get('admin/webservice/getCompanyID', 'Api\AdminController@getCompanyID');
    // Route::get('admin/companies', 'Api\AdminController@getAllCompanies');
    // Route::post('admin/company/create', 'Api\AdminController@createCompany');
    // Route::put('admin/company/edit', 'Api\AdminController@editCompany');

    // Route::get('admin/customers', 'Api\AdminController@getAllCustomers');
    // Route::post('admin/customer/create', 'Api\AdminController@createCustomer');
    // Route::put('admin/customer/edit', 'Api\AdminController@editCustomer');

    Route::get('admin/webservicedata', 'Api\AdminController@getAllWebserviceData');

    // Route::get('admin/companydata', 'Api\AdminController@getAllCompanyData');
    // Route::post('admin/companydata/create', 'Api\AdminController@createCompanyData');
    // Route::put('admin/companydata/edit', 'Api\AdminController@editCompanyData');
    // Route::delete('admin/companydata/delete', 'Api\AdminController@deleteCompanyData');

    // Route::put('admin/users/block', 'Api\AdminController@blockUser');
    // Route::put('admin/users/unblock', 'Api\AdminController@unblockUser');

    // Route::delete('admin/users/delete', 'Api\AdminController@deleteUser');

    // Route::get('admin/companydata/checkdelete', 'Api\AdminController@getCountUsersByCompanyID');

    // Route::get('admin/users/online', 'Api\AdminController@countUserOnline');

    // Route::get('admin/database/log', 'Api\AdminController@getLogList');
    // Route::get('admin/database/log/folder', 'Api\AdminController@getFolderLogs');
    // Route::get('admin/database/log/file', 'Api\AdminController@getFileLogByFolder');
    // Route::get('admin/database/logfile', 'Api\AdminController@getFileLog');
    // Route::post('admin/database/log/file/download', 'Api\AdminController@downloadFileLog');
    // Route::delete('admin/database/log/file/delete', 'Api\AdminController@deleteFileLog');

    Route::post('admin/webservice/addRegisWebService', 'Api\AdminController@addRegisWebService');
    Route::post('admin/webservice/editRegisWebService', 'Api\AdminController@editRegisWebService');
    Route::post('admin/webservice/deletewebservice', 'Api\AdminController@deletewebservice');

    // Route::get('admin/infographic/getInfoByUserID', 'Api\AdminController@getAllInfograpic');
    // Route::get('admin/infographic/getInfoByInfoID', 'Api\AdminController@getInfograpicData');
    // Route::post('admin/infographic/create', 'Api\AdminController@createInfograpic');
    // Route::put('admin/infographic/update', 'Api\AdminController@updateInfograpic');
    // Route::put('admin/infographic/updateInfoData', 'Api\AdminController@updateInfograpicData');
    // Route::delete('admin/infographic/delete', 'Api\AdminController@deleteInfograpic');

    Route::get('admin/infographic/getDatasource', 'Api\AdminController@getDatasourceInfo');
    Route::post('admin/infographic/createDatasource', 'Api\AdminController@addDatasourceInfo');

    // Customer
    // Route::get('customer/companies', 'Api\CustomerController@getCompanyListForCustomer');
    // Route::put('customer/companies', 'Api\CustomerController@approveCompany');
});
