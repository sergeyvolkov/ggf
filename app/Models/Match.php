<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    const GAME_TYPE_GROUP_STAGE = 'group';
    const GAME_TYPE_QUALIFY = 'qualify';
    const GAME_TYPE_FINAL = 'final';

    const RESULT_TYPE_HOME_WIN = 'home';
    const RESULT_TYPE_AWAY_WIN = 'away';
    const RESULT_TYPE_DRAW = 'draw';
    const RESULT_TYPE_HOME_PENALTY_WIN = 'home_penalty';
    const RESULT_TYPE_AWAY_PENALTY_WIN = 'away_penalty';

    const STATUS_STARTED = 'started';
    const STATUS_NOT_STARTED = 'not_started';
    const STATUS_FINISHED = 'finished';

    /**
     * @return array
     */
    static public function getAvailableResultTypes()
    {
        return [
            self::RESULT_TYPE_HOME_WIN,
            self::RESULT_TYPE_AWAY_WIN,
            self::RESULT_TYPE_DRAW,
            self::RESULT_TYPE_HOME_PENALTY_WIN,
            self::RESULT_TYPE_AWAY_PENALTY_WIN,
        ];
    }

    /**
     * @return array
     */
    static public function getAvailableGameTypes()
    {
        return [
            self::GAME_TYPE_GROUP_STAGE,
            self::GAME_TYPE_QUALIFY,
            self::GAME_TYPE_FINAL,
        ];
    }

    /**
     * @return array
     */
    static public function getAvailableStatuses()
    {
        return [
            self::STATUS_STARTED,
            self::STATUS_NOT_STARTED,
            self::STATUS_FINISHED,
        ];
    }
}
