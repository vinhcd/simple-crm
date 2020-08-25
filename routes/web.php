<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', '\App\Module\User\Controllers\ProfileController@index')->middleware('auth')->name('home');

Route::get('/test', function () {
    ddd(auth()->user()->isSuperAdmin());
});

//todo: fake login for mobile app
Route::match(['get', 'post'], '/mobile-login', 'MobileController@login')->name('mobile_login');
