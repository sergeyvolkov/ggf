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
        Route::post('/leagues', 'API\LeagueController@store');
        Route::get('/leagueTeams', 'API\LeagueController@teams');

        Route::get('/tournaments', 'API\TournamentController@catalogue');
        Route::post('/tournaments', 'API\TournamentController@store');
        Route::get('/tournaments/{tournamentId}', 'API\TournamentController@find');
        Route::put('/tournaments/{tournamentId}', 'API\TournamentController@update');

        Route::get('/teams', 'API\TournamentTeamController@catalogue');
        Route::post('/teams', 'API\TournamentTeamController@add');
        Route::get('/teams/search', 'API\TeamController@search');

        Route::get('/teams/{teamId}', 'API\TeamController@find');
        Route::delete('/teams/{teamId}', 'API\TeamController@remove');

        Route::get('/teamMembers', 'API\TeamMemberController@catalogue');
        Route::post('/teamMembers', 'API\TeamMemberController@assign');
        Route::delete('/teamMembers/{teamMemberId}', 'API\TeamMemberController@remove');
        Route::get('/teamMembers/search', 'API\TeamMemberController@search');

        Route::get('/tablescores', 'API\TournamentController@tablescore');

        Route::get('/matches', 'API\MatchController@catalogue');

        Route::group(['middleware' => ['before-match-update']], function() {
            Route::put('/matches/{matchId}', 'API\MatchController@update');
        });


        Route::get('/me', 'API\MemberController@current');
    });
});

Route::get('/', function () {
    return view('app');
});

Route::get('/welcome', function () {
    return view('welcome');
});
