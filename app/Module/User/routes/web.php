<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], 'login', 'AuthController@login')
    ->name('login');
Route::get('/logout', 'AuthController@logout')
    ->name('user_logout');

// User
Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/list', 'AuthController@list')
        ->name('user_list')
        ->middleware('user.list');

    Route::middleware('user.edit')->group(function () {
        Route::match(['get', 'post'], '/resetpwd/{id}', 'AuthController@resetPassword')
            ->name('user_reset_pwd');
        Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'AuthController@createOrUpdate')
            ->name('user_create_update');
        Route::get('/delete/{id}',  'AuthController@delete')
            ->name('user_delete');
        Route::get('/recover/{id}',  'AuthController@recover')
            ->name('user_recover');
    });
});

// Profile
Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', 'ProfileController@index')
        ->name('user_profile');
    Route::post('/avatar/{id}', 'ProfileController@changeAvatar')
        ->name('user_change_avatar');
    Route::match(['get', 'post'], '/changepwd', 'ProfileController@changePassword')
        ->name('user_change_pwd');
    Route::match(['get', 'post'], '/update', 'ProfileController@updateProfile')
        ->name('user_profile_update');
});

// Group
Route::prefix('group')->middleware('auth')->group(function () {
    Route::get('/list', 'GroupController@list')
        ->name('user_group_list')
        ->middleware('group.list');

    Route::middleware('group.edit')->group(function () {
        Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'GroupController@createOrUpdate')
            ->name('user_group_create_update');
        Route::post('/update-users/{id?}',  'GroupController@updateUsers')
            ->name('user_group_update_users');
        Route::get('/delete/{id}',  'GroupController@delete')
            ->name('user_group_delete');
    });
});

// Position
Route::prefix('position')->middleware('auth')->group(function () {
    Route::get('/list', 'PositionController@list')
        ->name('user_position_list')
        ->middleware('position.list');

    Route::middleware('position.edit')->group(function () {
        Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'PositionController@createOrUpdate')
            ->name('user_position_create_update');
        Route::get('/delete/{id}',  'PositionController@delete')
            ->name('user_position_delete');
    });
});

// Department
Route::prefix('department')->middleware('auth')->group(function () {
    Route::get('/list', 'DepartmentController@list')
        ->name('user_depart_list')
        ->middleware('depart.list');

    Route::middleware('depart.edit')->group(function () {
        Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'DepartmentController@createOrUpdate')
            ->name('user_depart_create_update');
        Route::post('/update-users/{id?}',  'DepartmentController@updateUsers')
            ->name('user_depart_update_users');
        Route::get('/delete/{id}',  'DepartmentController@delete')
            ->name('user_depart_delete');
    });
});
