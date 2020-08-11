<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], 'login', 'AuthController@login')->name('login');

Route::prefix('user')->middleware('auth')->group(function () {

    Route::get('/logout', 'AuthController@logout')->name('user_logout');
    Route::get('/list', 'AuthController@list')->name('user_list');
    Route::match(['get', 'post'], '/create/{id?}', 'AuthController@createOrUpdate')->name('user_create_update');
});
