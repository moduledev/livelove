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

// Route::group(['middleware' => ['json.response']], function () {

    Route::middleware('auth:api')->group(function () {
        Route::get('/users', 'Api\v1\ProfileController@index');
        Route::put('/users', 'Api\v1\ProfileController@update');
//        Route::delete('/users/delete/{id}', 'Api\ProfileController@delete');
    });

    Route::post('/smsverify', 'Api\v1\AuthController@verify');
    Route::post('/login', 'Api\v1\AuthController@login')->name('login.api');
    Route::post('/register', 'Api\v1\AuthController@register')->name('register');

//    Route::get('/fbauth','Api\v1\FbAuthController@fbauth')->name('fb.auth');
//    Route::get('/callback','Api\v1\FbAuthController@fbcallback')->name('fb.auth');

    Route::middleware('auth:api')->group(function () {
        Route::get('/logout', 'Api\v1\AuthController@logout')->name('logout');
    });

// });