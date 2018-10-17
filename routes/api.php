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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('Auth','Api\AuthController@login');

Route::post('login', 'UserController@authenticate');

Route::get('open', 'DataController@open'); //test


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('closed', 'DataController@closed'); //test

    Route::get('company/users','Api\CompanyController@getAllUser');
    Route::post('company/users', 'Api\CompanyController@addUserCompany');
    Route::put('company/users/block','Api\CompanyController@blockUserCompany');
    
    Route::get('company/customers','Api\CompanyController@getAllCustomer');
    Route::post('company/customers','Api\CompanyController@addUserCustomer');
    Route::get('company/customers/count','Api\CompanyController@countUserCustomer');

    /* Admin */
    Route::get('admin/administer','Api\AdminController@getAllAdminister');
    Route::post('admin/administer/create','Api\AdminController@createAdminister');  

    Route::get('admin/companies','Api\AdminController@getAllCompanies');
    Route::post('admin/company/create','Api\AdminController@createCompany');

    Route::get('admin/customers','Api\AdminController@getAllCustomers');
    Route::post('admin/customer/create','Api\AdminController@createCustomer');

    Route::get('admin/companydata','Api\AdminController@getAllCompanyData');
    Route::post('admin/companydata/create','Api\AdminController@createCompanyData');
});

