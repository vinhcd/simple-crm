<?php

use Illuminate\Support\Facades\Route;

Route::prefix('manager')->middleware('auth')->group(function () {

    // Plan
    Route::prefix('plan')->group(function () {
        Route::get('/', 'PlanController@index')
            ->name('manager_plan_list');
        Route::match(['get', 'post'], '/plan/createOrUpdate/{id?}', 'PlanController@edit')
            ->name('manager_plan_edit');
        Route::get('/plan/delete/{id}', 'PlanController@delete')
            ->name('manager_plan_delete');
    });

    // Organization
    Route::prefix('organization')->group(function () {
        Route::get('/', 'OrganizationController@index')
            ->name('manager_organization_list');
        Route::match(['get', 'post'], '/createOrUpdate/{id?}', 'OrganizationController@edit')
            ->name('manager_organization_edit');
        Route::get('/delete/{id}', 'OrganizationController@delete')
            ->name('manager_organization_delete');
    });

    // Order
    Route::prefix('order')->group(function () {
        Route::get('/', 'OrderController@index')
            ->name('manager_order_list');
        Route::match(['get', 'post'], '/edit/{id?}', 'OrderController@edit')
            ->name('manager_order_edit');
        Route::get('/delete/{id}', 'OrderController@delete')
            ->name('manager_order_delete');
    });
});
