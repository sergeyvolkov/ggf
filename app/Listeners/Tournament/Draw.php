<?php

namespace App\Listeners\Tournament;

use App\Events\Tournament\AbstractTournamentDrawEvent;
use App\Events\TournamentWasStarted;
use App\Jobs\Tournament\DrawKnockOut;
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
     * @param  AbstractTournamentDrawEvent  $event
     * @return void
     */
    public function handle(AbstractTournamentDrawEvent $event)
    {
        $tournament = $event->tournament;

        switch ($tournament->type) {
            case Tournament::TYPE_LEAGUE:
                $job = new DrawLeague($tournament);
                $job->handle();
                break;

            case Tournament::TYPE_KNOCK_OUT:
                $job = new DrawKnockOut($tournament);
                $job->handle();
                break;
            case Tournament::TYPE_MULTISTAGE:
                throw new \RuntimeException('Not implemented');
                break;
        }
    }
}
