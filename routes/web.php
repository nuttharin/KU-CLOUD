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

<<<<<<< HEAD
Route::get('/Company','CompanyController@index');

Route::get('/Customer','CustomerController@index');
=======
Route::get('/Company/User','CompanyController@user');

Route::get('/Company/Static','CompanyController@static');
>>>>>>> 621f99f2c8a8ff238d9841abc940752dcdbeb181
