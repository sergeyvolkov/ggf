<?php

namespace App\Listeners\Tournament;

use App\Models\Match;
use App\Models\Tournament as TournamentModel;
use App\Events\Tournament\TournamentWasReset;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class Reset
{
    /**
     * @var TournamentModel
     */
    protected $tournament;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TournamentWasReset  $event
     * @return void
     */
    public function handle(TournamentWasReset $event)
    {
        $this->tournament = $event->tournament;

        $this->reset();
    }

    protected function reset()
    {
        $this->cleanupMatches();
    }

    protected function cleanupMatches()
    {
        return Match::where(['tournamentId' => $this->tournament->id])->delete();
    }
}
