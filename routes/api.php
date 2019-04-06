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

Route::get('company/logo/{file_logo}', 'Api\CompanyPublicController@getLogoCompany');
Route::get('account/profile/{file_name}', 'Api\AccountsController@getProfile');

Route::get('companyList/public', 'Api\CompanyPublicController@getCompanyList');

Route::get('dashboards/public', 'Api\DashboardController@getAllPublicDashboard');
Route::get('dashboards/public/{dashboard_id}', 'Api\DashboardController@getDashboardPublicById');
Route::get('datasources/public', 'Api\DatasourceController@getDatasourcesPublic');

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
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'admin',
], function ($router) {

    Route::get('administer', 'Api\UserController@getAllAdminister');
    Route::post('administer/create', 'Api\UserController@createAdminister');
    Route::put('administer/edit', 'Api\UserController@editAdminister');

    Route::get('companies', 'Api\UserController@getAllCompanies');
    Route::post('company/create', 'Api\UserController@createCompany');
    Route::put('company/edit', 'Api\UserController@editCompany');

    Route::get('customers', 'Api\UserController@getAllCustomers');
    Route::post('customer/create', 'Api\UserController@createCustomer');
    Route::put('customer/edit', 'Api\UserController@editCustomer');

    Route::put('users/block', 'Api\UserController@blockUser');

    Route::delete('users/delete', 'Api\UserController@deleteUser');

    Route::get('companydata', 'Api\CompanyController@getAllCompanyData');
    Route::post('companydata/create', 'Api\CompanyController@createCompanyData');
    Route::put('companydata/edit', 'Api\CompanyController@editCompanyData');
    Route::delete('companydata/delete', 'Api\CompanyController@deleteCompanyData');

    Route::get('companydata/checkdelete', 'Api\CompanyController@getCountUsersByCompanyID');

    Route::get('users/online', 'Api\AdminController@countUserOnline');

    Route::get('webservice/getCompanyID', 'Api\AdminController@getCompanyID');

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

//log
    
    Route::get('database/log', 'Api\AdminController@getLogList');

    
    Route::post('database/log/folder/download', 'Api\AdminController@downloadFileLogByFolder');
    Route::get('database/log/folder', 'Api\AdminController@getFolderLogs');
    Route::delete('database/log/folder', 'Api\AdminController@delelteFileLogByFolder');

    Route::get('database/log/file', 'Api\AdminController@getFileLogByFolder');
    Route::get('database/logfile', 'Api\AdminController@getFileLog');

    Route::post('database/log/file/download', 'Api\AdminController@downloadFileLog');
    Route::delete('database/logfile', 'Api\AdminController@deleteFileLog');

    // Route::get('infographic/getInfoByUserID', 'Api\AdminController@getAllInfograpic');
    // Route::get('infographic/getInfoByInfoID', 'Api\AdminController@getInfograpicData');
    // Route::post('infographic/create', 'Api\AdminController@createInfograpic');
    // Route::put('infographic/update', 'Api\AdminController@updateInfograpic');
    // Route::put('infographic/updateInfoData', 'Api\AdminController@updateInfograpicData');
    // Route::delete('infographic/delete', 'Api\AdminController@deleteInfograpic');

    // Route::post('infographic/createDatasource', 'Api\AdminController@addDatasourceInfo');

});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'company',
], function ($router) {
    Route::get('test', 'Api\CompanyController@test'); //test
    Route::post('/logo', 'Api\CompanyController@uploadLogo');

    // Route::get('users', 'Api\CompanyController@getAllUser');
    // Route::post('users', 'Api\CompanyController@addUserCompany');
    // Route::put('users/block', 'Api\CompanyController@blockUserCompany');
    // Route::put('users/edit', 'Api\CompanyController@editUserCompany');
    // Route::delete('users/phone', 'Api\CompanyController@deletePhoneUser');
    // Route::delete('users/email', 'Api\CompanyController@deleteEmailUser');
    // Route::get('users/online', 'Api\CompanyController@countUserOnline');

    // Route::get('customers', 'Api\CompanyController@getAllCustomer');
    // Route::post('customers', 'Api\CompanyController@addUserCustomer');
    // Route::post('customers/company', 'Api\CompanyController@addCustomerInCompany');
    // Route::get('customers/email', 'Api\CompanyController@getAllEmailCustomer');

    //Static
    // Route::get('static', 'Api\CompanyController@getStaticDashboard');
    // Route::post('static', 'Api\CompanyController@addStatic');
    // Route::delete('static', 'Api\CompanyController@deleteStatic');
    // Route::get('static/{static_id}', 'Api\CompanyController@getStaticDashboardById');
    // Route::put('static', 'Api\CompanyController@updateStatic');
    // Route::put('static/dashboard', 'Api\CompanyController@updateStaticDashboard');

    // Route::get('staticDatasource', 'Api\CompanyController@getDatasourceStatic');
    // Route::post('static/datasource', 'Api\CompanyController@addDatasourceStatic');
    // Route::delete('static/datasource', 'Api\CompanyController@deleteDatasourceByStatic');

    // Route::get('analysis/data', 'Api\Company\AnalysisController@getAllDataAnalysis');
    // Route::get('analysis/data/{data_id}', 'Api\Company\AnalysisController@getByIdDataAnalysis');
    // Route::post('analysis/data', 'Api\Company\AnalysisController@createDataAnalysis');
    // Route::delete('analysis/data', 'Api\Company\AnalysisController@deleteDataAnalysis');
    // Route::post('analysis/data/upload', 'Api\Company\AnalysisController@uploadFile');
    // Route::post('analysis', 'Api\Company\AnalysisController@analysisProcess');

    Route::get('database/log/download', 'Api\CompanyController@downloadFileLog');
    Route::get('database/log/file', 'Api\CompanyController@getFileLogByFolder');
    Route::get('database/logfile', 'Api\CompanyController@getFileLog');
    Route::delete('database/logfile', 'Api\CompanyController@deleteFileLog');

});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'users',
], function ($router) {
    Route::get('/', 'Api\UserController@getAllUser');
    Route::post('/', 'Api\UserController@addUserCompany');
    Route::put('/block', 'Api\UserController@blockUserCompany');
    Route::put('/edit', 'Api\UserController@editUserCompany');
    Route::delete('/phone', 'Api\UserController@deletePhoneUser');

    Route::get('/email/company', 'Api\UserController@getAllEmailCustomerInCompany');
    Route::get('/username/company', 'Api\UserController@getAllUsernameCustomerInCompany');
    Route::delete('/email', 'Api\UserController@deleteEmailUser');

    Route::get('/online', 'Api\UserController@countUserOnline');
    Route::get('me', 'Api\AuthController@me');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'customers',
], function ($router) {
    Route::get('/', 'Api\UserController@getAllCustomer');
    Route::post('/', 'Api\UserController@addUserCustomer');
    Route::post('/company', 'Api\UserController@addCustomerInCompany');

    Route::get('/email', 'Api\UserController@getAllEmailCustomer');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'analysis',
], function ($router) {
    Route::get('/download/{file_name}', 'Api\AnalysisController@downloadFile');
    Route::get('/data', 'Api\AnalysisController@getAllDataAnalysis');
    Route::get('/data/{data_id}', 'Api\AnalysisController@getByIdDataAnalysis');
    Route::post('/data', 'Api\AnalysisController@createDataAnalysis');
    Route::delete('/data', 'Api\AnalysisController@deleteDataAnalysis');
    Route::post('/data/upload', 'Api\AnalysisController@uploadFile');
    Route::post('/', 'Api\AnalysisController@analysisProcess');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'infographic',
], function ($router) {
    Route::get('getInfoByUserType', 'Api\InfographicController@getAllInfograpic');
    Route::get('getInfoByInfoID', 'Api\InfographicController@getInfograpicData');
    Route::get('getCustomerByCompany', 'Api\InfographicController@getCustomerByCompany');
    Route::post('create', 'Api\InfographicController@createInfograpic');
    Route::put('update', 'Api\InfographicController@updateInfograpic');
    Route::put('updateInfoData', 'Api\InfographicController@updateInfograpicData');
    Route::delete('delete', 'Api\InfographicController@deleteInfograpic');
    Route::post('createDatasource', 'Api\InfographicController@addDatasourceInfo');
    Route::get('getDatasource', 'Api\InfographicController@getDatasourceInfo');
    Route::get('getServiceByTypeUser', 'Api\InfographicController@getServiceByTypeUser');
    Route::get('getApiDaily', 'Api\InfographicController@getApiDaily');
    Route::get('getApiMonthly', 'Api\InfographicController@getApiMonthly');
    Route::get('getApiYearly', 'Api\InfographicController@getApiYearly');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'static',
], function ($router) {
    Route::get('/', 'Api\StaticController@getStaticDashboard');
    Route::post('/', 'Api\StaticController@addStatic');
    Route::put('/', 'Api\StaticController@updateStatic');
    Route::delete('/', 'Api\StaticController@deleteStatic');

    Route::get('{static_id}', 'Api\StaticController@getStaticDashboardById');

    Route::put('dashboard', 'Api\StaticController@updateStaticDashboard');

    Route::post('datasource', 'Api\StaticController@addDatasourceStatic');
    Route::delete('datasource', 'Api\StaticController@deleteDatasourceByStatic');

});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'dashboards',
], function ($router) {
    Route::get('{dashboard_id}', 'Api\DashboardController@getDashboardById');
    Route::put('layout', 'Api\DashboardController@updateDashboardLayout');
    Route::get('/', 'Api\DashboardController@getAllDashboard');
    Route::get('/company/customers', 'Api\DashboardController@getDashboardCustomerInCompany');

    Route::post('/', 'Api\DashboardController@createDashboard');
    Route::put('/', 'Api\DashboardController@updateDashboard');
    Route::delete('/', 'Api\DashboardController@deleteDashboard');

    Route::post('datasource', 'Api\DatasourceController@createDatasource');
    Route::delete('datasource', 'Api\DatasourceController@deleteDatasource');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
], function ($router) {
    Route::get('staticDatasource', 'Api\StaticController@getDatasourceStatic');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'datasources',
], function ($router) {
    Route::get('/', 'Api\DatasourceController@getDatasources');
    Route::get('/customer', 'Api\DatasourceController@getDatasourcesCustomer');
    Route::post('/', 'Api\DatasourceController@createDatasource');
    Route::delete('/', 'Api\DatasourceController@deleteDatasource');
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

    Route::post('profile', 'Api\AccountsController@uploadProfile');

    Route::put('username', 'Api\AccountsController@updateUsername');

    Route::post('name', 'Api\AccountsController@updateName');

    Route::put('email', 'Api\AccountsController@changePrimaryEmail');
    Route::post('email', 'Api\AccountsController@addEmail');
    Route::delete('email', 'Api\AccountsController@deleteEmail');

    Route::put('phone', 'Api\AccountsController@changePrimaryPhone');
    Route::post('phone', 'Api\AccountsController@addPhone');
    Route::delete('phone', 'Api\AccountsController@deletePhone');

    Route::post('address', 'Api\AccountsController@addAddress');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'iot',
], function ($router) {
    Route::get('iotservicedata', 'Api\IoTController@getAllIotserviceData');
    Route::get('IoTdata', 'Api\IoTController@IoTdata');
    Route::get('getkeyiot', 'Api\IoTController@getKeyiot');

    Route::post('addRegisIotService_url', 'Api\IoTController@addRegisIotService_url');
    Route::post('deleteIoT', 'Api\IoTController@deleteIoT');
    Route::post('iotupdatedata', 'Api\IoTController@iotupdatedata');
    Route::post('getOutput', 'Api\IoTController@getDataOutput');
    Route::post('addRegisIotService', 'Api\IoTController@addRegisIotService');
    Route::post('addOutputRegisIotService', 'Api\IoTController@addOutputRegisIotService');

});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'companies',
], function ($router) {
    Route::get('me', 'Api\CompanyController@getCompanyById');
    Route::put('me', 'Api\CompanyController@updateCompanyId');

});

//TEAM ADD
Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'webservices',
], function ($router) {
    Route::get('/company', 'Api\WebServiceController@getWebServiceByCompany');
});

//TEAM ADD
Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'register/webservices',
], function ($router) {
    Route::get('/', 'Api\RegisterWebserviceController@getAllRegisterWebservice');
    Route::post('/', 'Api\RegisterWebserviceController@createRegister');
    Route::delete('/', 'Api\RegisterWebserviceController@deleteRegister');
    Route::get('/{webservice_id}/emails', 'Api\RegisterWebserviceController@getEmailCustomerByWebserviceId');
});

//TEAM ADD
Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'register/iotServices',
], function ($router) {
    Route::get('/', 'Api\RegisterIoTServiceController@getAllRegister');
    Route::post('/', 'Api\RegisterIoTServiceController@createRegister');
    Route::delete('/', 'Api\RegisterIoTServiceController@deleteRegister');
    Route::get('/{iotservice_id}/emails', 'Api\RegisterIoTServiceController@getEmailCustomerByIotServiceId');
});

Route::group(['middleware' => ['jwt.verify']], function () {

    Route::get('closed', 'DataController@closed'); //test

    //company get
    Route::get('company/webservices', 'Api\CompanyController@getWebServiceByCompany');
    Route::get('company/webservicedata', 'Api\CompanyController@getAllWebserviceData');
    Route::get('company/webservice/getCompanyID', 'Api\CompanyController@getCompanyID');
    // Route::get('company/iot/iotservicedata','Api\CompanyController@getAllIotserviceData');
    // Route::get('company/iot/getkeyiot', 'Api\CompanyController@getKeyiot');
    //admin get
    Route::get('admin/infographic/getDatasource', 'Api\AdminController@getDatasourceInfo');
    Route::get('admin/webservicedata', 'Api\AdminController@getAllWebserviceData');

    //company post
    Route::post('company/webservice/editRegisWebService', 'Api\CompanyController@editRegisWebService');
    Route::post('company/webservice/addRegisWebService', 'Api\CompanyController@addRegisWebService');
    // Route::post('company/iot/addRegisIotService', 'Api\CompanyController@addRegisIotService');
    // Route::post('company/iot/addOutputRegisIotService', 'Api\CompanyController@addOutputRegisIotService');
    Route::post('company/webservice/deletewebservice', 'Api\CompanyController@deletewebservice');
    Route::post('company/gettabledw', 'Api\CompanyController@getAllWebserviceData');
    Route::post('company/webservice/downloadJSONFile', 'Api\CompanyController@downloadJSONFile');

    //admin post
    Route::post('admin/webservice/addRegisWebService', 'Api\AdminController@addRegisWebService');
    Route::post('admin/webservice/editRegisWebService', 'Api\AdminController@editRegisWebService');
    Route::post('admin/webservice/deletewebservice', 'Api\AdminController@deletewebservice');
    Route::post('admin/infographic/createDatasource', 'Api\AdminController@addDatasourceInfo');

});
