<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/** USERS */
Route::get('/security/users', 'Security\UsersController@index');
Route::get('/security/users/create', 'Security\UsersController@openForm');
Route::post('/security/users/create', 'Security\UsersController@create');
Route::get('/security/users/update', 'Security\UsersController@edit');
Route::post('/security/users/update', 'Security\UsersController@update');
Route::post('/security/users/destroy', 'Security\UsersController@destroy');