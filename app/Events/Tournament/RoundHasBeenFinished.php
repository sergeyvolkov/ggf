<?php

namespace App\Events\Tournament;

use App\Events\Tournament\AbstractTournamentDrawEvent;
use App\Models\Tournament;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RoundHasBeenFinished extends AbstractTournamentDrawEvent
{
    use SerializesModels;
}
