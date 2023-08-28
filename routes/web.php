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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('main');
});

/** USERS */
Route::get('/users/user', 'Users\UserController@index');
Route::get('/security/users/create', 'Security\UsersController@openForm');
// Route::post('/security/users/create', 'Security\UsersController@create');
// Route::get('/security/users/update', 'Security\UsersController@edit');
// Route::post('/security/users/update', 'Security\UsersController@update');
// Route::post('/security/users/destroy', 'Security\UsersController@destroy');

/** STORE GROUP */
Route::get('/master/group-store', 'Master\StoreGroupController@index');
Route::get('/master/group-store/save-group', 'Master\StoreGroupController@openForm');   
Route::post('/master/group-store/create', 'Master\StoreGroupController@create');
Route::get('/master/group-store/update', 'Master\StoreGroupController@edit');
Route::post('/master/group-store/update', 'Master\StoreGroupController@update');
Route::post('/master/group-store/destroy', 'Master\StoreGroupController@destroy');