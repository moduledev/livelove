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
        Route::get('/users', 'Api\ProfileController@index');
        Route::post('/users/edit', 'Api\ProfileController@update');
//        Route::delete('/users/delete/{id}', 'Api\ProfileController@delete');
    });

    Route::post('/user/smsverify', 'Api\AuthController@verify');
    Route::post('/login', 'Api\AuthController@login')->name('login.api');
    Route::post('/register', 'Api\AuthController@register')->name('register');

    Route::middleware('auth:api')->group(function () {
        Route::get('/logout', 'Api\AuthController@logout')->name('logout');
    });

});