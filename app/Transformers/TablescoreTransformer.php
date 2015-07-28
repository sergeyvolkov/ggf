<?php

namespace App\Transformers;

use App\Models\Match;
use Illuminate\Support\Collection;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\TransformerAbstract;

class TablescoreTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];

    public function transform($teamRank)
    {
        return [
            'teamId' => $teamRank['teamId'],
            'matches' => array_get($teamRank, 'matches', 0),
            'rank' => array_get($teamRank, 'rank', 0),
            'wins' => array_get($teamRank, 'wins', 0),
            'draws' => array_get($teamRank, 'draws', 0),
            'losts' => array_get($teamRank, 'losts', 0),
            'points' => array_get($teamRank, 'points', 0),
            'goalsScored' => array_get($teamRank, 'goalsScored', 0),
            'goalsAgainsted' => array_get($teamRank, 'goalsAgainsted', 0),
            'goalsDifference' => array_get($teamRank, 'goalsDifference', 0)
        ];
    }
}