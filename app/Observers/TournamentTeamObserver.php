<?php

namespace App\Observers;

use App\Events\TournamentWasReset;
use App\Events\TournamentWasStarted;
use App\Models\TournamentTeam;
use Illuminate\Support\Facades\Log;

class TournamentTeamObserver
{
    public function saving(TournamentTeam $model)
    {
        Log::info('Hahahaha');
    }
}