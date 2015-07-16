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

Route::group(['middleware' => 'cors'], function() {

    Route::post('/auth/facebook/token', 'Auth\FacebookController@token');
    Route::post('/auth/logout', 'AuthController@logout');

    Route::resource('tournament', 'TournamentController');
    Route::resource('team', 'TeamController');
    Route::resource('member', 'MemberController');
    Route::resource('match', 'MatchController');

    // API

    Route::group(['prefix' => 'api/v1', 'middleware' => []], function() {
        Route::get('/leagues', 'API\LeagueController@catalogue');

        Route::get('/tournaments', 'API\TournamentController@catalogue');
        Route::get('/tournaments/{tournamentId}', 'API\TournamentController@find');
        Route::put('/tournaments/{tournamentId}', 'API\TournamentController@update');

        Route::get('/teams/{teamId}', 'API\TeamController@find');
        
        Route::get('/matches', 'API\TournamentController@matches');
        Route::get('/teams', 'API\TournamentController@teams');
        Route::post('/teams', 'API\TournamentController@addTeam');
        Route::get('/me', 'API\MemberController@current');
    });
});

Route::get('/', function () {
    return view('app');
});

Route::get('/welcome', function () {
    return view('welcome');
});
