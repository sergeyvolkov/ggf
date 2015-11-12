<?php

namespace App\Observers;

use App\Events\Tournament\TournamentWasReset;
use App\Events\Tournament\TournamentWasStarted;
use App\Models\Tournament;
use Illuminate\Support\Facades\Log;

class TournamentObserver
{
    public function updating(Tournament $model)
    {
        $dirtyStatus = array_get($model->getDirty(), 'status');

        if (Tournament::STATUS_STARTED === $dirtyStatus
            && 1 > $model->matches()->getResults()->count()
        ) {
            Log::debug('Tournament ' . $model->name . ' was started');

            event(new TournamentWasStarted($model));
        }

        if (Tournament::STATUS_DRAFT === $dirtyStatus) {
            Log::debug('Tournament ' . $model->name . ' was reset');

            event(new TournamentWasReset($model));
        }
    }
}