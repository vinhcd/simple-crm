<?php

use Illuminate\Support\Facades\Route;

Route::prefix('contract')->middleware('auth')->group(function () {

    // Contract
    Route::get('/', 'ContractController@index')
        ->name('contract_list');
    Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'ContractController@createOrUpdate')
        ->name('contract_create_update');
    Route::get('/delete/{id}',  'ContractController@delete')
        ->name('contract_delete');

    // Template
    Route::prefix('template')->group(function () {
        Route::get('/', 'ContractTemplateController@index')
            ->name('contract_template_list');
        Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'ContractTemplateController@createOrUpdate')
            ->name('contract_template_create_update');
        Route::get('/delete/{id}',  'ContractTemplateController@delete')
            ->name('contract_template_delete');
    });

    // User
    Route::prefix('user')->group(function () {
        Route::get('/', 'ContractUserController@index')
            ->name('contract_user_list');
        Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'ContractUserController@createOrUpdate')
            ->name('contract_user_create_update');
        Route::get('/delete/{id}',  'ContractUserController@delete')
            ->name('contract_user_delete');
    });
});
