<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware(['api', 'manager.apikey'])->group(function () {

    Route::post('/update-organization', 'ApiController@updateOrganization')->name('api_update_organization');
    Route::post('/update-plans', 'ApiController@updatePlans')->name('api_update_plans');
});
