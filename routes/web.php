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

Route::get('/Customer','CustomerController@index');

Route::get('/Company/User','CompanyController@user');

Route::get('/Company/Static','CompanyController@static');
//Route::get('/')
Route::get('/Company/Service','CompanyController@service');

Route::get('/Company/Service/AddService','CompanyController@Add_service');

Route::get('/Company/Service/ShowService','CompanyController@Show_service');



