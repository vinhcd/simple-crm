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
        return redirect('/admin');
    });
});

// Admin routes
Route::match(['get', 'post'], 'admin/login', 'Admin\AuthController@login')->name('admin_login');
Route::prefix('admin')->namespace('Admin')->middleware('auth')->group(function () {
    Route::get('/', 'DashboardController@index')->name('admin_dashboard');
    Route::get('/logout', 'AuthController@logout')->name('admin_logout');

    Route::get('/user', 'AuthController@list')->name('admin_user_list');
    Route::match(['get', 'post'], '/user/create', 'AuthController@create')->name('admin_user_create');

    Route::get('/plan', 'PlanController@index')->name('admin_plan_list');
    Route::match(['get', 'post'], '/plan/create', 'PlanController@create')->name('admin_plan_create');

    Route::get('/organization', 'OrganizationController@index')->name('admin_organization_list');
    Route::match(['get', 'post'], '/organization/create', 'OrganizationController@create')->name('admin_organization_create');
});
