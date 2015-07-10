<?php

namespace App\Providers;

use Illuminate\Session\SessionServiceProvider as ISessionServiceProvider;

class SessionServiceProvider extends ISessionServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSessionManager();

        $this->registerSessionDriver();

        $this->app->singleton('App\Http\Middleware\StartSession');
    }
}
