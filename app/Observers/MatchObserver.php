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

        if (Match::RESULT_TYPE_UNKNOWN === $resultType
            && Match::STATUS_FINISHED === $dirtyStatus
        ) {
            event(new MatchWasFinished($model));
        }
    }
}