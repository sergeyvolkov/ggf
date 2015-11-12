<?php

namespace App\Events\Tournament;

use App\Events\Event;
use App\Events\Tournament\InterfaceTournamentDraw;
use App\Models\Tournament;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TournamentWasStarted extends AbstractTournamentDrawEvent
{
    use SerializesModels;
}