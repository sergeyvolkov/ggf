<?php

namespace App\Observers;

use App\Events\MatchWasFinished;
use App\Models\Match;
use Illuminate\Support\Facades\Log;

class MatchObserver
{
    public function updating(Match $model)
    {
        $dirtyStatus = array_get($model->getDirty(), 'status');
        $resultType = array_get($model->getOriginal(), 'resultType');

        // original score values
        $originalHomeScore = array_get($model->getOriginal(), 'homeScore');
        $originalAwayScore = array_get($model->getOriginal(), 'awayScore');

        // dirty score values
        $dirtyHomeScore = array_get($model->getDirty(), 'homeScore');
        $dirtyAwayScore = array_get($model->getDirty(), 'awayScore');

        if ((Match::RESULT_TYPE_UNKNOWN === $resultType && Match::STATUS_FINISHED === $dirtyStatus)
            || ($originalHomeScore !== $dirtyHomeScore || $originalAwayScore !== $dirtyAwayScore)
        ) {
            event(new MatchWasFinished($model));
        }
    }
}