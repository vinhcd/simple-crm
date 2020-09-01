<?php

use Illuminate\Support\Facades\Route;

Route::prefix('contract')->middleware('auth')->group(function () {

    Route::get('/', 'ContractController@index')
        ->name('contract_list');
    Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'ContractController@createOrUpdate')
        ->name('contract_create_update');
    Route::get('/delete/{id}',  'ContractController@delete')
        ->name('contract_delete');
});
