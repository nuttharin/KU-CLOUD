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






Route::get('/','AuthController@index');
Route::get('/Auth','AuthController@index');

Route::get('/Register','RegisterController@index');



Route::group(['middleware' => ['jwt.verify.web']], function() {

    Route::get('/Compnay/Customer','CompanyController@customer');
    Route::get('/Compnay/Infographic','CompanyController@infographic');
    Route::get('/Company/Static','CompanyController@staticDatatable');
    Route::get('/Company/Static/{id}','CompanyController@static');
    
    Route::get('/Company/Service','CompanyController@service');
    Route::get('/Company/Service/AddService','CompanyController@Add_service');
    Route::get('/Company/Service/ShowService','CompanyController@Show_service');
    Route::get('/Company/Service/OutputService','CompanyController@Output_service');
    
    Route::get('/Company/User','CompanyController@user');
    Route::get('/Company/ManageAccounts','CompanyController@manageAccounts');

    Route::get('/Company/LogViewer','CompanyController@LogViewer');

    Route::get('/Company/Logout','CompanyController@Logout');
    Route::get('/Company/test','CompanyController@test');
    Route::get('/Company/Service/EditService/{id}','CompanyController@EditService');

    /* Admin */
    Route::get('/Admin/ManageAccounts','AdminController@manageAccounts');
    Route::get('/Admin/UsersAdminister','AdminController@UsersAdminister');
    Route::get('/Admin/UsersCompany','AdminController@UsersCompany');
    Route::get('/Admin/UsersCustomer','AdminController@UsersCustomer');
    Route::get('/Admin/Company','AdminController@Company');
    Route::get('/Admin/Infographic','AdminController@Infographic');
    Route::get('/Admin/Static','AdminController@Static');
    Route::get('/Admin/LogViewer','AdminController@LogViewer');
    Route::get('/Admin/AddService','AdminController@AddService');
    Route::get('/Admin/Service','AdminController@service');
    Route::get('/Admin/Service/AddService','AdminController@Add_service');
    Route::get('/Admin/Service/EditService/{id}','AdminController@EditService');

    Route::get('/Admin/Infographic/{id}','AdminController@InfographicCustom');
});


