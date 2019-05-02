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


Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('register', 'AdminController@create')->name('admin.register');
    Route::post('register', 'AdminController@store')->name('admin.register.store');
    Route::get('login', 'Auth\Admin\LoginController@login')->name('admin.auth.login');
    Route::post('login', 'Auth\Admin\LoginController@loginAdmin')->name('admin.auth.loginAdmin');
    Route::post('logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');

    Route::get('users','AdminController@users')->name('admin.users');
    Route::get('admins','AdminController@admins')->name('admin.admins');

    Route::post('users','UserController@destroy')->name('admin.user.delete');
    Route::get('users/{id}','UserController@edit')->name('admin.user.edit');
});

Route::get('/', function () {
    return redirect('http://ll_front.jdev.com.ua/');
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');



