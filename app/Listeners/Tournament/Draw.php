<?php

namespace App\Listeners\Tournament;

use App\Events\TournamentWasStarted;
use App\Jobs\Tournament\DrawLeague;
use App\Models\Tournament;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class Draw
{
    /**
     * Handle the event.
     *
     * @param  TournamentWasStarted  $event
     * @return void
     */
    public function handle(TournamentWasStarted $event)
    {
        $tournament = $event->tournament;

        switch ($tournament->type) {
            case Tournament::TYPE_LEAGUE:
                $job = new DrawLeague($tournament);
                $job->handle();
                break;

            case Tournament::TYPE_KNOCK_OUT:
            case Tournament::TYPE_MULTISTAGE:
                throw new \RuntimeException('Not implemented');
                break;
        }
    }
}
