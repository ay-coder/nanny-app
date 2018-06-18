<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api',], function () 
{
    Route::post('login', 'UsersController@login')->name('api.login');
    Route::post('register', 'UsersController@create')->name('api.register');
    Route::post('forgotpassword', 'UsersController@forgotPassword')->name('api.forgotPassword');
    Route::get('config', 'UsersController@config')->name('api.config');
    Route::get('profile-completion', 'UsersController@profileCompletion')->name('api.profile-completion');

    /*Route::post('verifyotp', 'UsersController@verifyOtp')->name('api.verifyotp');
    Route::post('resendotp', 'UsersController@resendOtp')->name('api.resendotp');
    Route::post('forgotpassword', 'UsersController@forgotPassword')->name('api.forgotPassword');
    Route::post('specializations', 'SpecializationController@specializationList')->name('api.specializationList');
    Route::post('removeotp', 'UsersController@removeOtp')->name('api.removeotp');
    // send next appointment notification
    Route::post('sendnext', 'PatientsController@sendNextAppoint')->name('api.sendnext');*/
});

Route::group(['namespace' => 'Api', 'middleware' => 'jwt.customauth'], function () 
{
    Route::post('user-profile', 'UsersController@getUserProfile')->name('api.user-profile');
    Route::post('update-user-profile', 'UsersController@updageUserProfile')->name('api.update-user-profile');
    Route::post('update-password', 'UsersController@updageUserPassword')->name('api.update-user-password');
    Route::get('logout', 'UsersController@logout')->name('api.logout');
});

Route::group(['middleware' => 'jwt.customauth'], function () 
{
    includeRouteFiles(__DIR__.'/API/');
});