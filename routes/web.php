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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Admin','AdminController@index');

Route::get('/Admin/User','AdminController@user');

Route::get('/Admin/Company','AdminController@company');







Route::get('/Auth','AuthController@index');



Route::group(['middleware' => ['jwt.verify.web']], function() {
    Route::get('/Company/User','CompanyController@user');
    Route::get('/Company/Static','CompanyController@static');
    //Route::get('/')
    Route::get('/Company/Service','CompanyController@service');

    Route::get('/Company/Service/AddService','CompanyController@Add_service');

    Route::get('/Company/Service/ShowService','CompanyController@Show_service');
    Route::get('/Customer','CustomerController@index');
});


