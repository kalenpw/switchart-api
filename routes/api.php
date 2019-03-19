<?php

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

Route::get('/games/', 'GamesController@index');
Route::get('/games/name/{name}', 'GamesController@show');
Route::get('/games/id/{id}', 'GamesController@byId');
Route::post('/games/update/', 'GamesController@update');
Route::post('/games/store', 'GamesController@store');

Route::post('/users/show', 'UsersController@show');

Route::post('/artwork/store', 'ArtworkController@store');
Route::post('/artwork/destroy', 'ArtworkController@destroy');
Route::get('/artwork/id/{id}', 'ArtworkController@showId');
Route::get('/artwork/game/{name}', 'ArtworkController@show');
Route::get('/artwork/user/{id}', 'ArtworkController@getUsers');

Route::post('/vote/upvote/', 'VoteController@upvote');
Route::post('/vote/downvote/', 'VoteController@downvote');
Route::get('/vote/artwork/{id}', 'VoteController@artworkVotes');

Route::post('/test', function (Request $request) {
    $requestToken = $request->token;
    $token = JWTAuth::getToken();

    if ($token == $requestToken) {
        $apy = JWTAuth::getPayload($token)->toArray();
        return $apy['sub'];
    }
    return "NOT VALIDATED";
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
