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
    Route::get('programs', 'DashboardController@programs')->name('dashboard.programs');
    Route::get('roles', 'DashboardController@roles')->name('dashboard.roles');

    Route::get('login', 'Auth\Admin\LoginController@login')->name('login');
    Route::post('login', 'Auth\Admin\LoginController@loginAdmin')->name('admin.auth.loginAdmin');
    Route::post('logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');

    Route::post('admin/admins', 'AdminController@store')->name('admin.register.store');
    Route::get('edit/edit/{id}', 'AdminController@edit')->name('admin.admins.edit');
    Route::get('edit/{id}', 'AdminController@show')->name('admin.admins.show');
    Route::put('admin/admins/edit/{id}', 'AdminController@update')->name('admin.admins.update');
    Route::delete('admin/admins/{id}', 'AdminController@destroy')->name('admin.admins.delete');
    Route::post('admin/edit', 'PermissionController@removePermission')->name('remove.permission');
    Route::put('admin/edit', 'PermissionController@assignPermission')->name('assign.permission');

    Route::post('users', 'UserController@destroy')->name('admin.user.delete');
    Route::get('users/edit{id}', 'UserController@edit')->name('admin.user.edit');
    Route::get('users/{id}', 'UserController@show')->name('admin.user.show');
    Route::put('users/edit/{id}', 'UserController@update')->name('admin.users.update');
    Route::put('users', 'UserController@assignProgram')->name('assign.program');
    Route::post('users/edit', 'UserController@removeProgram')->name('remove.program');

    Route::get('roles/edit{id}', 'RoleController@edit')->name('admin.role.edit');
    Route::put('roles/edit', 'RoleController@assignRole')->name('assign.role');
    Route::post('roles/edit', 'RoleController@removeRole')->name('remove.role');
    Route::post('roles', 'RoleController@store')->name('add.role');
    Route::delete('roles', 'RoleController@destroy')->name('delete.role');
    Route::get('roles/{id}', 'RoleController@show')->name('show.role');
    Route::put('roles/edit/{id}', 'RoleController@update')->name('admin.roles.update');

    Route::get('programs/create', 'ProgramController@createProgram')->name('create.program');
    Route::post('programs', 'ProgramController@storeProgram')->name('add.program');
    Route::get('programs/edit/{id}', 'ProgramController@editProgram')->name('edit.program');
    Route::get('programs/{id}', 'ProgramController@showProgram')->name('show.program');
    Route::put('programs/edit/{id}', 'ProgramController@updateProgram')->name('update.program');
    Route::delete('programs', 'ProgramController@delete')->name('delete.program');
    

    Route::any('search', 'SearchController@search')->name('search');

});

// Route::group(['middleware' => ['auth:admin']], function () {
//     Route::resource('users', 'UserController');
// });

Route::get('/', function () {
    return redirect(route('login'));
});


Route::get('/fbauth','Api\v1\FbAuthController@fbauth')->name('fb.auth');
Route::get('/callback','Api\v1\FbAuthController@fbcallback');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');



