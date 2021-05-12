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

Route::get('/login', 'App\Http\Controllers\Login@index');
Route::get('/user-home', 'App\Http\Controllers\ClientController@index');
Route::get('/checkUser', 'App\Http\Controllers\ClientController@checkUser');
//Route::get('/user-home', 'App\Http\Controllers\ClientController@userHome');
Route::get('/callback', 'App\Http\Controllers\Callback@index');
Route::get('/user-profile', 'App\Http\Controllers\ClientController@profile');
Route::get('/settings', 'App\Http\Controllers\ClientController@settings');