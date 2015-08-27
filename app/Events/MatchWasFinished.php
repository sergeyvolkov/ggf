<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Match;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MatchWasFinished extends Event
{
    use SerializesModels;

    /**
     * @var Match
     */
    public $match;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Match $match)
    {
        $this->match = $match;
    }
}
