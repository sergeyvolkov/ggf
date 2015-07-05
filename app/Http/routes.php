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

Route::get('/', function () {
    return view('app');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::resource('tournament', 'TournamentController');

// API

Route::group(['prefix' => 'api/v1', 'middleware' => []], function() {
    // @todo Move to middleware
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        $origin = $_SERVER['HTTP_ORIGIN'];

        // @todo Move list of allow origins to config
        if (in_array($origin, ['http://localhost:4200'])) {
            header("Access-Control-Allow-Origin: $origin");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
            header('Access-Control-Allow-Credentials: true');
        }
    }

    Route::get('/tournaments', 'API\TournamentController@catalogue');
});