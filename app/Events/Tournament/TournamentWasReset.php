<?php

namespace App\Events\Tournament;

use App\Events\Event;
use App\Models\Tournament;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TournamentWasReset extends AbstractTournamentDrawEvent
{
    use SerializesModels;
}