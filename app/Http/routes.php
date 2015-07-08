<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'allow-origin'], function() {

    Route::post('/auth/facebook/token', 'Auth\FacebookController@token');

    Route::resource('tournament', 'TournamentController');

    // API

    Route::group(['prefix' => 'api/v1', 'middleware' => []], function() {
        Route::get('/tournaments', 'API\TournamentController@catalogue');
    });
});

Route::get('/', function () {
    return view('app');
});

Route::get('/welcome', function () {
    return view('welcome');
});
