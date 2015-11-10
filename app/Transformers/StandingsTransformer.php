<?php

namespace App\Transformers;

use App\Models\Match;
use Illuminate\Support\Collection;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\TransformerAbstract;

class StandingsTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];

    public function transform($pair)
    {
        return [
            'id' => $pair['id'],
            'tournamentId' => $pair['tournamentId'],
            'round' => $pair['round'],
            'homeTeamId' => $pair['homeTeamId'],
            'homeTeamName' => $pair['homeTeamName'],
            'awayTeamId' => $pair['awayTeamId'],
            'awayTeamName' => $pair['awayTeamName'],
            'matches' => $pair['matches']
        ];
    }
}