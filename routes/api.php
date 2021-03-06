<?php

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

Route::group([
    'prefix' => 'v1/auth',
], function () {

    Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
    Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');
    
    Route::get('email/verify/{token}', 'App\Http\Controllers\Auth\MailVerifyController@verify')->name('verification.verify');
    Route::get('email/resend/{email}', 'App\Http\Controllers\Auth\MailResendController@resend');

    Route::group(['middleware' => 'auth:api'], function () {
		Route::post('logout', 'App\Http\Controllers\Auth\LogoutController@logout');
		Route::get('me', 'App\Http\Controllers\Auth\meController@me');
	});
});

Route::group([
    'prefix' => 'v1/password',
], function () {
    Route::post('sendtoken', 'App\Http\Controllers\Auth\ResetPasswordController@store');
    Route::get('find/{token?}', 'App\Http\Controllers\Auth\ResetPasswordController@find');
    Route::post('resetpassword','App\Http\Controllers\Auth\ResetPasswordController@resetpassword');
});