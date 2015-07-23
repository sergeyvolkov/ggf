<?php

namespace App\Observers;

use App\Models\Tournament;
use App\Events\TournamentWasStarted;
use Illuminate\Support\Facades\Log;

class TournamentObserver
{
    public function updating(Tournament $model)
    {
        $dirtyStatus = array_get($model->getDirty(), 'status');

        Log::debug('Tournament ' . $model->name . ' was started');

        if (Tournament::STATUS_STARTED === $dirtyStatus
            && 1 > $model->matches()->getResults()->count()
        ) {
            event(new TournamentWasStarted($model));
        }
    }
}