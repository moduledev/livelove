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
    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::get('admins', 'DashboardController@admins')->name('dashboard.admins');
    Route::get('users', 'DashboardController@users')->name('dashboard.users');

    Route::get('login', 'Auth\Admin\LoginController@login')->name('admin.auth.login');
    Route::post('login', 'Auth\Admin\LoginController@loginAdmin')->name('admin.auth.loginAdmin');
    Route::post('logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');

    Route::post('admin/admins', 'AdminController@store')->name('admin.register.store');
    Route::get('edit/{id}', 'AdminController@edit')->name('admin.admins.edit');
    Route::put('admin/admins/edit/{id}','AdminController@update')->name('admin.admins.update');
    Route::delete('admin/admins/{id}','AdminController@destroy')->name('admin.admins.delete');

    Route::post('users', 'UserController@destroy')->name('admin.user.delete');
    Route::get('users/{id}', 'UserController@edit')->name('admin.user.edit');

    Route::post('admin/edit','PermissionController@removePermission')->name('remove.permission');
    Route::put('admin/edit','PermissionController@assignPermission')->name('assign.permission');

});

Route::group(['middleware' => ['auth:admin']], function () {
    Route::resource('users', 'UserController');
});

Route::get('/', function () {
    return redirect('http://ll_front.jdev.com.ua/');
});


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');



