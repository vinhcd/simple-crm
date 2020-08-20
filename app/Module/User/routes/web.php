<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], 'login', 'AuthController@login')->name('login');

Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/logout', 'AuthController@logout')->name('user_logout');
    Route::match(['get', 'post'], '/resetpwd/{id}', 'AuthController@resetPassword')->name('user_reset_pwd');
    Route::get('/list', 'AuthController@list')->name('user_list');
    Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'AuthController@createOrUpdate')->name('user_create_update');
    Route::get('/delete/{id}',  'AuthController@delete')->name('user_delete');
    Route::get('/recover/{id}',  'AuthController@recover')->name('user_recover');
});

Route::prefix('group')->middleware('auth')->group(function () {
    Route::get('/list', 'GroupController@list')->name('user_group_list');
    Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'GroupController@createOrUpdate')->name('user_group_create_update');
    Route::get('/delete/{id}',  'GroupController@delete')->name('user_group_delete');
});
