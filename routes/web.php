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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login','App\Http\Controllers\CustomAuthController@login');
Route::get('/register','App\Http\Controllers\CustomAuthController@register');
Route::post('/register_user','App\Http\Controllers\CustomAuthController@register_user')->name('register_user');
Route::post('/login_user','App\Http\Controllers\CustomAuthController@login_user')->name('login_user');
Route::get('/dashboard','App\Http\Controllers\CustomAuthController@dashboard')->middleware('isLoggedIn');
Route::get('/logout','App\Http\Controllers\CustomAuthController@logout');
