<?php

namespace App\Providers;

use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Observers\TournamentObserver;
use App\Observers\TournamentTeamObserver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class EloquentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Tournament::observe(new TournamentObserver);
        TournamentTeam::observe(new TournamentTeamObserver);
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
