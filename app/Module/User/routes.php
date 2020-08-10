<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], 'login', '\App\Module\User\Controllers\AuthController@login')->name('login');

Route::get('/', function () {
    if (auth()->check()) {
        echo auth()->user()->name;
    } else {
        echo 'you need login';
    }
});

Route::namespace('\App\Module\User\Controllers')->prefix('user')->middleware('auth')->group(function () {
    Route::get('/list', function () {
        echo auth()->user()->name;
    });
});
