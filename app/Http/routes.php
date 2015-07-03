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
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/api/v1/tournaments', function () {
    return ['tournaments' => [
        [
            "id" => "5",
            "name" => "GGG International #2",
            "teams" => ["Spain", "Argentina", "Netherlands", "Colombia", "Uruguay", "Chile"],
            "description" => ""
        ]
    ]];
});