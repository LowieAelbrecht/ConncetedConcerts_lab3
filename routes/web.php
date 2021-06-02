<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MollieController;

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
Route::get('/user-rooms', 'App\Http\Controllers\ClientController@index');
Route::get('/user-discover', 'App\Http\Controllers\ClientController@discover');
Route::get('/concerts/{concerts}', 'App\Http\Controllers\ClientController@showConcert');
Route::get('/concertspayment/{concerts}', 'App\Http\Controllers\MollieController@preparePayment');
Route::get('/checkUser', 'App\Http\Controllers\ClientController@checkUser');
Route::post('/checkUser', 'App\Http\Controllers\ClientController@fixUser');
//Route::get('/user-home', 'App\Http\Controllers\ClientController@userHome');
Route::get('/callback', 'App\Http\Controllers\Callback@index');
Route::get('/user-profile', 'App\Http\Controllers\ClientController@profile');
Route::get('/settings', 'App\Http\Controllers\ClientController@settings');
Route::get('/changeArtist', 'App\Http\Controllers\ClientController@change');

Route::get('/add-concert', 'App\Http\Controllers\ArtistController@addConcert');
Route::post('/add-concert', 'App\Http\Controllers\ArtistController@storeConcert');

Route::get('/add-songvote', 'App\Http\Controllers\ArtistController@addSongVote');

//MOLLIE ROUTES
Route::get('mollie-paymnet',[MollieController::Class,'preparePayment'])->name('mollie.payment');
Route::get('payment-success',[MollieController::Class, 'paymentSuccess'])->name('payment.success');
