<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'v1',

], function () {
        Route::post('/forgot_password', 'UserAuthController@sendPasswordResetToken');
        Route::post('/verify_token', 'UserAuthController@validatePasswordResetToken');
        Route::post('/new_password', 'UserAuthController@setNewAccountPassword');

        Route::get('/api_password_token', 'UserAuthController@apiPasswordTokens');
        Route::get('/delete_api_password_token', 'UserAuthController@deleteAPITokens');

        Route::post('/login', 'UserAuthController@login');
        Route::post('/refresh_token', 'UserAuthController@refresh');
});
