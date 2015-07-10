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

    Route::group(['prefix' => 'api/v1', 'middleware' => ['auth.token']], function() {
        $apiGetMethods = ['get', 'options'];

        Route::match($apiGetMethods, '/tournaments', 'API\TournamentController@catalogue');
        Route::match($apiGetMethods, '/me', 'API\MemberController@current');
    });
});

Route::get('/', function () {
    return view('app');
});

Route::get('/welcome', function () {
    return view('welcome');
});
