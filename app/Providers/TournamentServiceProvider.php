<?php

namespace App\Providers;

use App\Models\Tournament;
use App\Observers\TournamentObserver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class TournamentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Tournament::observe(new TournamentObserver);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
