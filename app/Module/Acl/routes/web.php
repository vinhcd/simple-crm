<?php

use Illuminate\Support\Facades\Route;

Route::prefix('role')->middleware(['auth', 'role.manage'])->group(function () {
    Route::get('/', 'RoleController@index')->name('role_list');
    Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'RoleController@createOrUpdate')->name('role_create_update');
    Route::get('/delete/{id}',  'RoleController@delete')->name('role_delete');
});
