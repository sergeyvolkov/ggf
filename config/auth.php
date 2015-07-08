<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Authentication Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the authentication driver that will be utilized.
    | This driver manages the retrieval and authentication of the users
    | attempting to get access to protected areas of your application.
    |
    | Supported: "database", "eloquent"
    |
    */

    'driver' => 'eloquent',

    /*
    |--------------------------------------------------------------------------
    | Authentication Model
    |--------------------------------------------------------------------------
    |
    | When using the "Eloquent" authentication driver, we need to know which
    | Eloquent model should be used to retrieve your users. Of course, it
    | is often just the "User" model but you may use whatever you like.
    |
    */

    'model' => App\Models\Member::class,

    'providers' => [
        'facebook' => [
            'app_id' => env('FACEBOOK_APP_ID', ''),
            'app_secret' => env('FACEBOOK_APP_SECRET', ''),
            'redirect_uri' => env('FACEBOOK_REDIRECT_URI', ''),
        ]
    ]

];
