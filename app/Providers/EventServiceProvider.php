<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Tournament\TournamentWasStarted' => [
            'App\Listeners\Tournament\Draw',
        ],
        'App\Events\Tournament\TournamentWasReset' => [
            'App\Listeners\Tournament\Reset',
        ],
        'App\Events\MatchWasFinished' => [
            'App\Listeners\Match\UpdateResultType',
        ],
        'App\Events\Tournament\RoundHasBeenFinished' => [
            'App\Listeners\Tournament\Draw'
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
