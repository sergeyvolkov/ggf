<?php

namespace App\Jobs\Tournament;

use App\Models\Tournament;

abstract class Job extends \App\Jobs\Job
{
    /**
     * @var Tournament
     */
    protected $tournament;

    /**
     * @return void
     */
    public function __construct(Tournament $tournament)
    {
        $this->setTournament($tournament);
    }

    abstract protected function setTournament(Tournament $tournament);
}