<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/api-doc', 'SwaggerController@index');

Route::get('login', function() {
    return view('login');
})->name('login');

Route::post('login', 'AdminAuthController@login');
Route::get('/logout', 'AdminAuthController@logout');

Route::get('register', 'UserController@register');
Route::post('register_user', 'UserController@add_user');
Route::post('update_user', 'UserController@update_user');
Route::get('users', 'UserController@users');

Route::get('/', 'IndexController@index');
