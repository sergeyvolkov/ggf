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
            event(new TournamentWasStarted($model));
        }

        if (Tournament::STATUS_DRAFT === $dirtyStatus) {
            event(new TournamentWasReset($model));
        }
    }
}