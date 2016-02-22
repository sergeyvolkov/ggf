<?php

namespace App\Events\Tournament;

use App\Events\Event;
use App\Models\Tournament;

abstract class AbstractTournamentDrawEvent extends Event
{
    /**
     * @var Tournament
     */
    public $tournament;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }
}