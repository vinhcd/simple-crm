<?php

use Illuminate\Support\Facades\Route;

Route::prefix('manager')->middleware('auth')->group(function () {

    Route::get('/plan', 'PlanController@index')->name('manager_plan_list');
    Route::get('/plan/delete/{id}', 'PlanController@delete')->name('manager_plan_delete');
    Route::match(['get', 'post'], '/plan/createOrUpdate/{id?}', 'PlanController@createOrUpdate')->name('manager_plan_create_update');

    Route::get('/organization', 'OrganizationController@index')->name('manager_organization_list');
    Route::get('/organization/delete/{id}', 'OrganizationController@delete')->name('manager_organization_delete');
    Route::match(['get', 'post'], '/organization/createOrUpdate/{id?}', 'OrganizationController@createOrUpdate')->name('manager_organization_create_update');
});
