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

Route::match(['get', 'post'], 'login', 'User\AuthController@login')->name('login');
Route::middleware('user.db')->group(function () {
    Route::middleware('user.auth')->group(function () {
        Route::get('/', function () {
            echo auth()->user()->name;
        });
    });
});

// Admin routes
Route::middleware('admin.db')->prefix('admin')->group(function () {
    Route::match(['get', 'post'], 'login', 'Admin\AuthController@login')->name('admin_login');
    Route::namespace('Admin')->middleware('auth')->group(function () {
        Route::get('/', 'DashboardController@index')->name('admin_dashboard');
        Route::get('/logout', 'AuthController@logout')->name('admin_logout');

        Route::get('/user', 'AuthController@list')->name('admin_user_list');
        Route::match(['get', 'post'], '/user/create', 'AuthController@create')->name('admin_user_create');

        Route::get('/plan', 'PlanController@index')->name('admin_plan_list');
        Route::get('/plan/delete/{id}', 'PlanController@delete')->name('admin_plan_delete');
        Route::match(['get', 'post'], '/plan/createOrUpdate/{id?}', 'PlanController@createOrUpdate')->name('admin_plan_create_update');

        Route::get('/organization', 'OrganizationController@index')->name('admin_organization_list');
        Route::get('/organization/delete/{id}', 'OrganizationController@delete')->name('admin_organization_delete');
        Route::match(['get', 'post'], '/organization/createOrUpdate/{id?}', 'OrganizationController@createOrUpdate')->name('admin_organization_create_update');
    });
});
