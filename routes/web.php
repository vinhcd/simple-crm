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

Route::match(['get', 'post'], 'login', 'UserController@login')->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('test');
    });
});

Route::prefix('admin')->namespace('Admin')->group(function () {
    Route::match(['get', 'post'], 'login', 'AuthController@login')->name('admin_login');
    Route::get('/logout', 'AuthController@logout')->name('admin_logout');
    Route::match(['get', 'post'], '/create', 'AuthController@create')->name('admin_create');
    Route::get('/', 'DashboardController@index')->name('admin_dashboard');
    Route::get('/users', 'AuthController@list')->name('admin_list_user');
});
