<?php

namespace App\Auth;

use Facebook\FacebookSession;
use Illuminate\Support\Facades\Config;
use Illuminate;

class AuthManager extends Illuminate\Auth\AuthManager
{
    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);

        FacebookSession::setDefaultApplication(
            Config::get('auth.providers.facebook.app_id'),
            Config::get('auth.providers.facebook.app_secret')
        );
    }

    /**
     * @inheritdoc
     */
    public function createEloquentDriver()
    {
        $provider = $this->createEloquentProvider();

        return new Guard($provider, $this->app['session.store']);
    }


}
