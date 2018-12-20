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


Route::post('Auth','Api\AuthController@login');

Route::post('login', 'UserController@authenticate');

Route::get('open', 'DataController@open'); //test




Route::group(['middleware' => ['jwt.verify']], function() {
   

    Route::get('closed', 'DataController@closed'); //test

    //Company
    Route::get('company/test', 'Api\CompanyController@test'); //test
    Route::get('company/users','Api\CompanyController@getAllUser');
    Route::post('company/users', 'Api\CompanyController@addUserCompany');
    Route::put('company/users/block','Api\CompanyController@blockUserCompany');
    Route::put('company/users/edit','Api\CompanyController@editUserCompany');
    Route::delete('company/users/phone','Api\CompanyController@deletePhoneUser');
    Route::delete('company/users/email','Api\CompanyController@deleteEmailUser');
    Route::get('company/users/online','Api\CompanyController@countUserOnline');

    Route::get('company/customers','Api\CompanyController@getAllCustomer');
    Route::post('company/customers','Api\CompanyController@addUserCustomer');


    Route::get('company/database/log/file','Api\CompanyController@getFileLogByFolder');
    Route::get('company/database/logfile','Api\CompanyController@getFileLog');

    Route::get('company/webservices','Api\CompanyController@getWebServiceByCompany');
    Route::get('company/webservicedata','Api\CompanyController@getAllWebserviceData');
    Route::post('company/webservice/editRegisWebService','Api\CompanyController@editRegisWebService');
    Route::post('company/webservice/addRegisWebService','Api\CompanyController@addRegisWebService');
    Route::get('company/webservice/getCompanyID','Api\CompanyController@getCompanyID');
    Route::post('company/webservice/deletewebservice','Api\CompanyController@deletewebservice');

    Route::get('company/static','Api\CompanyController@getStaticDashboard');
    Route::post('company/static','Api\CompanyController@addStatic');
    Route::get('company/static/{static_id}','Api\CompanyController@getStaticDashboardById');
    Route::put('company/static','Api\CompanyController@updateStatic');
    Route::put('company/static/dashboard','Api\CompanyController@updateStaticDashboard');
    Route::delete('company/static','Api\CompanyController@deleteStatic');

    Route::get('company/staticDatasource','Api\CompanyController@getDatasourceStatic');
    Route::post('company/static/datasource','Api\CompanyController@addDatasourceStatic');

    
    /* Admin */
    Route::get('admin/administer','Api\AdminController@getAllAdminister');
    Route::post('admin/administer/create','Api\AdminController@createAdminister');
    Route::put('admin/administer/edit','Api\AdminController@editAdminister');
    Route::get('admin/webservice/getCompanyID','Api\AdminController@getCompanyID');
    Route::get('admin/companies','Api\AdminController@getAllCompanies');
    Route::post('admin/company/create','Api\AdminController@createCompany');
    Route::put('admin/company/edit','Api\AdminController@editCompany');

    Route::get('admin/customers','Api\AdminController@getAllCustomers');
    Route::post('admin/customer/create','Api\AdminController@createCustomer');
    Route::put('admin/customer/edit','Api\AdminController@editCustomer');

    Route::get('admin/webservicedata','Api\AdminController@getAllWebserviceData');

    Route::get('admin/companydata','Api\AdminController@getAllCompanyData');
    Route::post('admin/companydata/create','Api\AdminController@createCompanyData');
    Route::put('admin/companydata/edit','Api\AdminController@editCompanyData');
    Route::delete('admin/companydata/delete','Api\AdminController@deleteCompanyData');

    Route::put('admin/users/block','Api\AdminController@blockUser');  
    Route::put('admin/users/unblock','Api\AdminController@unblockUser');

    Route::delete('admin/users/delete','Api\AdminController@deleteUser');

    Route::get('admin/companydata/checkdelete','Api\AdminController@getCountUsersByCompanyID');
    
    Route::get('admin/users/online','Api\AdminController@countUserOnline');

    
    Route::get('admin/database/log','Api\AdminController@getLogList');
    Route::get('admin/database/log/folder','Api\AdminController@getFolderLogs');
    Route::get('admin/database/log/file','Api\AdminController@getFileLogByFolder');
    Route::get('admin/database/logfile','Api\AdminController@getFileLog');
    Route::post('admin/database/log/file/download','Api\AdminController@downloadFileLog');
    Route::delete('admin/database/log/file/delete','Api\AdminController@deleteFileLog');
    Route::post('admin/webservice/addRegisWebService','Api\AdminController@addRegisWebService');
    Route::post('admin/webservice/editRegisWebService','Api\AdminController@editRegisWebService');
    Route::post('admin/webservice/deletewebservice','Api\AdminController@deletewebservice');

    Route::get('admin/infographic/getInfoByUserID','Api\AdminController@getAllInfograpic');
    Route::get('admin/infographic/getInfoByInfoID','Api\AdminController@getInfograpicData');
    Route::post('admin/infographic/create','Api\AdminController@createInfograpic');
    Route::put('admin/infographic/update','Api\AdminController@updateInfograpic');
    Route::put('admin/infographic/updateInfoData','Api\AdminController@updateInfograpicData');
    Route::delete('admin/infographic/delete','Api\AdminController@deleteInfograpic');
});

