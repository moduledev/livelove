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


Route::group(['middleware' => ['json.response']], function () {

    Route::middleware('auth:api')->group(function () {
        Route::post('/user/smsverify', 'Api\AuthController@verify');
        Route::get('/users/{id}', 'Api\ProfileController@index');
        Route::delete('/users/{id}', 'Api\ProfileController@delete');
        Route::put('/users/edit/{id}', 'Api\ProfileController@update');
    });

    Route::post('/login', 'Api\AuthController@login')->name('login.api');
    Route::post('/register', 'Api\AuthController@register')->name('register.api');

    Route::middleware('auth:api')->group(function () {
        Route::get('/logout', 'Api\AuthController@logout')->name('logout');
    });

});