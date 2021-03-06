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

Route::get('/', 'App\Http\Controllers\Login@index');
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


Route::get('/checkUser', 'App\Http\Controllers\ClientController@checkUser');
Route::post('/checkUser', 'App\Http\Controllers\ClientController@fixUser');
Route::get('/choose-artist', 'App\Http\Controllers\ClientController@chooseArtist');
Route::post('/choose-artist', 'App\Http\Controllers\ClientController@storeArtist');
Route::get('/callback', 'App\Http\Controllers\Callback@index');
Route::get('/user-profile', 'App\Http\Controllers\ClientController@profile');
Route::get('/settings', 'App\Http\Controllers\ClientController@settings');

// TUTORIALS
Route::get('/tutorial', 'App\Http\Controllers\ClientController@tutorial');

Route::view('/tutorial-artist1', '/artist-tutorial1');
Route::view('/tutorial-artist2', '/artist-tutorial2');
Route::view('/artist-tutorial3', '/artist-tutorial3');
Route::view('/artist-tutorial4', '/artist-tutorial4');
Route::view('/artist-tutorial5', '/artist-tutorial5');
Route::view('/artist-tutorial6', '/artist-tutorial6');

Route::view('/tutorial-user1', '/user-tutorial1');
Route::view('/tutorial-user2', '/user-tutorial2');
Route::view('/user-tutorial3', '/user-tutorial3');
Route::view('/user-tutorial4', '/user-tutorial4');
Route::view('/user-tutorial5', '/user-tutorial5');
Route::view('/user-tutorial6', '/user-tutorial6');


Route::get('/add-concert', 'App\Http\Controllers\ArtistController@addConcert');
Route::post('/add-concert', 'App\Http\Controllers\ArtistController@storeConcert');

Route::get('/add-songvote', 'App\Http\Controllers\ArtistController@addSongVote');
Route::post('/add-songvote', 'App\Http\Controllers\ArtistController@storeSongVote');

Route::get('/add-bingo', 'App\Http\Controllers\ArtistController@addBingo');
Route::post('/add-bingo', 'App\Http\Controllers\ArtistController@storeBingo');

Route::get('/finish-concert', 'App\Http\Controllers\ArtistController@finishConcert');
Route::post('/finish-concert', 'App\Http\Controllers\ArtistController@publishConcert');

Route::get('/delete-room', 'App\Http\Controllers\ArtistController@deleteRoom');

Route::get('/new-post/{concerts}', 'App\Http\Controllers\ArtistController@addPost');
Route::post('/add-post/{concerts}', 'App\Http\Controllers\ArtistController@storePost');


Route::get('/comments/{concerts}/post/{post}', 'App\Http\Controllers\ClientController@addComment');

// AJAX ROUTES
Route::post('getAlbumTracks', 'App\Http\Controllers\ArtistController@getAlbumTracks');
Route::post('insertVote', 'App\Http\Controllers\ClientController@insertVote');
Route::post('checkReceived', 'App\Http\Controllers\ArtistController@checkReceived');
Route::post('/search', 'App\Http\Controllers\ClientController@search');
Route::post('/check', 'App\Http\Controllers\ClientController@concertCheck');
Route::post('/likePost', 'App\Http\Controllers\ClientController@likePost');
Route::post('/unLikePost', 'App\Http\Controllers\ClientController@unLikePost');
Route::post('/addComment', 'App\Http\Controllers\ClientController@storeComment');
Route::post('/sortDistance', 'App\Http\Controllers\ClientController@sortDistance');
Route::post('/checkWinners', 'App\Http\Controllers\ClientController@checkWinners');

//MOLLIE ROUTES
Route::get('mollie-payment',[MollieController::Class,'preparePayment'])->name('mollie.payment');
Route::get('payment-success',[MollieController::Class, 'paymentSuccess'])->name('payment.success');
Route::name('webhooks.mollie')->post('webhooks/mollie', 'App\Http\Controllers\MollieController@handleRequest');
