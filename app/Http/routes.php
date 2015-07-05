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

Route::get('/api/v1/tournaments', function () {

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

    return ['tournaments' => [
        [
            "id" => "5",
            "name" => "GGG International #2",
            "teams" => ["Spain", "Argentina", "Netherlands", "Colombia", "Uruguay", "Chile"],
            "description" => ""
        ]
    ]];
});