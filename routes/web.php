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
Route::get('/social-room/{concerts}', 'App\Http\Controllers\ClientController@socialConcert');
Route::get('/vote-room/{concerts}', 'App\Http\Controllers\ClientController@voteConcert');
Route::get('/bingo-room/{concerts}', 'App\Http\Controllers\ClientController@bingoConcert');
Route::post('/bingo-room/{concerts}', 'App\Http\Controllers\ArtistController@bingoResults');
Route::get('/update-concert/{concerts}', 'App\Http\Controllers\ArtistController@updateConcert');
Route::post('/update-concert/{concerts}', 'App\Http\Controllers\ArtistController@saveUpdateConcert');
Route::get('/new-post/{concerts}', 'App\Http\Controllers\ArtistController@addPost');

Route::get('/checkUser', 'App\Http\Controllers\ClientController@checkUser');
Route::post('/checkUser', 'App\Http\Controllers\ClientController@fixUser');
Route::get('/callback', 'App\Http\Controllers\Callback@index');
Route::get('/user-profile', 'App\Http\Controllers\ClientController@profile');
Route::get('/settings', 'App\Http\Controllers\ClientController@settings');
Route::get('/changeArtist', 'App\Http\Controllers\ClientController@change');

Route::get('/add-concert', 'App\Http\Controllers\ArtistController@addConcert');
Route::post('/add-concert', 'App\Http\Controllers\ArtistController@storeConcert');

Route::get('/add-songvote', 'App\Http\Controllers\ArtistController@addSongVote');
Route::post('/add-songvote', 'App\Http\Controllers\ArtistController@storeSongVote');

Route::get('/add-bingo', 'App\Http\Controllers\ArtistController@addBingo');
Route::post('/add-bingo', 'App\Http\Controllers\ArtistController@storeBingo');

Route::get('/finish-concert', 'App\Http\Controllers\ArtistController@finishConcert');
Route::post('/finish-concert', 'App\Http\Controllers\ArtistController@publishConcert');

// AJAX ROUTES
Route::post('getAlbumTracks', 'App\Http\Controllers\ArtistController@getAlbumTracks');
Route::post('insertVote', 'App\Http\Controllers\ClientController@insertVote');
Route::post('checkReceived', 'App\Http\Controllers\ArtistController@checkReceived');
Route::post('/search', 'App\Http\Controllers\ClientController@search');

//MOLLIE ROUTES
Route::get('mollie-paymnet',[MollieController::Class,'preparePayment'])->name('mollie.payment');
Route::get('payment-success',[MollieController::Class, 'paymentSuccess'])->name('payment.success');
