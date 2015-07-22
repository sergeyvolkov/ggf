<?php

namespace App\Jobs\Tournament;

use App\Jobs\Job;
use App\Models\Tournament;
use Illuminate\Contracts\Bus\SelfHandling;

class HoldDraw extends Job implements SelfHandling
{
    /**
     * @var Tournament
     */
    protected $tournament;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dd($this->tournament);
    }
}
