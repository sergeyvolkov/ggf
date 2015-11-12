<?php

namespace App\Observers;

use App\Events\MatchWasFinished;
use App\Events\Tournament\RoundHasBeenFinished;
use App\Models\Match;
use App\Models\Tournament;
use Illuminate\Support\Facades\Log;

class MatchObserver
{
    public function updating(Match $model)
    {
        $dirtyStatus = array_get($model->getDirty(), 'status');

        // original score values
        $originalHomeScore = $model->getOriginal('homeScore');
        $originalAwayScore = $model->getOriginal('awayScore');

        // dirty score values
        $dirtyHomeScore = array_get($model->getDirty(), 'homeScore');
        $dirtyAwayScore = array_get($model->getDirty(), 'awayScore');

        $isMatchFinished = Match::RESULT_TYPE_UNKNOWN === $model->getOriginal('resultType')
            && Match::STATUS_FINISHED === $dirtyStatus;

        if ($isMatchFinished
            || ($originalHomeScore !== $dirtyHomeScore || $originalAwayScore !== $dirtyAwayScore)
        ) {
            event(new MatchWasFinished($model));
        }
    }

    public function updated(Match $model)
    {
        $status = array_get($model->getDirty(), 'status');
        $resultType = array_get($model->getDirty(), 'resultType');

        if (Match::RESULT_TYPE_UNKNOWN !== $resultType
            && Match::STATUS_FINISHED === $status
        ) {
            $currentRound = $model->round;

            $matches = $model->tournament->matches()
                ->where([
                    'round' => $currentRound, 'status' => Match::STATUS_NOT_STARTED
                ])
                ->get();

            if (Tournament::TYPE_KNOCK_OUT == $model->tournament->type && $matches->count() < 1) {
                event(new RoundHasBeenFinished($model->tournament));
            }
        }
    }


}