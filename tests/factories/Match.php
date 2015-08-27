<?php

$factory(\App\Models\Match::class, [
    'homeScore' => 0,
    'awayScore' => 0,
    'homePenaltyScore' => 0,
    'awayPenaltyScore' => 0,
    'round' => 1,
    'status' => \App\Models\Match::STATUS_NOT_STARTED,
    'gameType' => \App\Models\Match::GAME_TYPE_GROUP_STAGE,
    'resultType' => \App\Models\Match::RESULT_TYPE_UNKNOWN
]);