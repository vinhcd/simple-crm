<?php

use Illuminate\Support\Facades\Route;

Route::prefix('acl')->middleware('auth')->group(function () {
    Route::get('/', 'AclController@index')->name('acl_list');
    Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'AclController@createOrUpdate')->name('acl_create_update');
    Route::post('/update-permissions/{id?}',  'AclController@updatePermissions')->name('acl_update_permissions');
    Route::get('/delete/{id}',  'AclController@delete')->name('acl_delete');
});
