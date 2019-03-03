<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('user/verify/{verification_code}/{email}', 'AuthController@verifyUser');
Route::get('forgetPassword/resetPassword/{verification_code}/{email}', 'AuthController@resetPassword');

// Route::get('/', 'AuthController@index');

Route::post('/Auth/Login', 'AuthController@Login');

Route::get('/Auth/ResetPasswordFirst/{user_id}/{token}', 'AuthController@ResetPasswordFirst');

Route::get('/', 'HomeController@Index');
Route::get('/Home', 'HomeController@Index');

Route::get('/Register', 'RegisterController@index');
Route::get('/ForgetPassword', 'AuthController@forgetPassword');
Route::post('/ForgetPasswordSendMail', 'AuthController@forgetPasswordSendMail');
Route::post('/ResetPasswordPost', 'AuthController@resetPasswordPost');

Route::group(['middleware' => ['jwt.verify.web']], function () {

    Route::post('/SetCookie', 'AuthController@SetCookie');

    //Route::get('/Compnay/Customer', 'CompanyController@customer');
    Route::get('/Compnay/Infographic', 'CompanyController@infographic');
    //Route::get('/Company/Static', 'CompanyController@staticDatatable');
    //Route::get('/Company/Static/{id}', 'CompanyController@static');

    // Route::get('/Company/Analysis/PrepareData', 'CompanyController@AnalysisPrepareData');
    // Route::get('/Company/Analysis/DataAnalysis', 'CompanyController@DataAnalysis');
    // Route::get('/Company/Analysis/OutputDataAnalysis', 'CompanyController@DataAnalysisOutput');

    Route::get('/Company/Service', 'CompanyController@service');
    Route::get('/Company/Service/AddService', 'CompanyController@Add_service');
    Route::get('/Company/Service/ShowService', 'CompanyController@Show_service');
    Route::get('/Company/Service/OutputService', 'CompanyController@Output_service');

    // Route::get('/Company/IoT', 'CompanyController@iot');
    
    Route::get('/Company/IoT/Add_InputIot', 'CompanyController@Add_InputIot');
    Route::get('/Company/IoT/Add_OutputIot', 'CompanyController@Add_OutputIot');

    Route::get('/Company/ManageAccounts', 'CompanyController@manageAccounts');

    Route::get('/Company/LogViewer', 'CompanyController@LogViewer');

    Route::get('/Company/test', 'CompanyController@test');
    Route::get('/Company/testAsso', 'CompanyController@testAsso');
    Route::get('/Company/testClassi', 'CompanyController@testClassi');
    Route::get('/Company/testRegression', 'CompanyController@testRegression');
    Route::get('/Company/Service/EditService/{id}', 'CompanyController@EditService');
    
    //IoT
    Route::get('IoT', 'IoTController@IoT');

    Route::get('/Company/Logout', 'CompanyController@Logout');

    /* Admin */
    Route::get('/Admin/ManageAccounts', 'AdminController@manageAccounts');
    Route::get('/Admin/UsersAdminister', 'AdminController@UsersAdminister');
    Route::get('/Admin/UsersCompany', 'AdminController@UsersCompany');
    Route::get('/Admin/UsersCustomer', 'AdminController@UsersCustomer');
    //Route::get('/Admin/Company', 'AdminController@Company');
    //Route::get('/Admin/Infographic', 'AdminController@Infographic');

    Route::get('/Admin/Static/{id}', 'AdminController@static');
    Route::get('/Admin/Static', 'AdminController@staticDatatable');

    Route::get('/Admin/LogViewer', 'AdminController@LogViewer');
    Route::get('/Admin/AddService', 'AdminController@AddService');
    Route::get('/Admin/Service', 'AdminController@service');
    Route::get('/Admin/Service/AddService', 'AdminController@Add_service');
    Route::get('/Admin/Service/EditService/{id}', 'AdminController@EditService');

    Route::get('/Admin/Infographic/{id}', 'AdminController@InfographicCustom');

    //Company
    Route::get('/Admin/Company', 'CompanyController@Index');

    //RegisterWebservice
    Route::get('/Register/Webservice', 'RegisterWebserviceController@Webservice');
    Route::get('/Register/IoT', 'RegisterIoTServiceController@IoT');

    //Customer
    Route::get('/Customer/User', 'CustomerController@Index');
    Route::get('/Customer/ManageAccounts', 'CustomerController@ManageAccounts');
    Route::get('/Customer/ManageCompany', 'CustomerController@ManageCompany');
    Route::get('/Customer/Infographic', 'CustomerController@Infographic');

    //Infographic
    Route::get('/Infographic', 'InfographicController@Index');
    Route::get('/Infographic/{id}/{name}', 'InfographicController@CustomInfographic');

    //User
    Route::get('/User/Administer', 'UserController@UserAdminister');
    Route::get('/User/Company', 'UserController@UserCompany');
    Route::get('/User/Customer', 'UserController@UserCustomer');

    //Analysis
    Route::get('/Analysis/PrepareData', 'AnalysisController@AnalysisPrepareData');
    Route::get('/Analysis/DataAnalysis', 'AnalysisController@DataAnalysis');
    Route::get('/Analysis/OutputDataAnalysis', 'AnalysisController@DataAnalysisOutput');

    // Dashboards
    Route::get('/Dashboards', 'DashboardController@Index');
    Route::get('/Dashboards/{id}', 'DashboardController@CustomDashboard');

    // LogViewer
    Route::get('/LogViewer', 'LogViewerController@Index');

});
