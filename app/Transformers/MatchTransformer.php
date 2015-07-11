<?php

namespace App\Transformers;

use App\Models\Match;
use League\Fractal\TransformerAbstract;

class MatchTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];

    public function transform(Match $match)
    {
        return [
            'id' => $match->id,
            'homeTeam' => $match->homeTournamentTeam->team->name,
            'awayTeam' => $match->awayTournamentTeam->team->name,
            'homeScore' => $match->homeScore,
            'awayScore' => $match->awayScore,
            'tournamentId' => $match->tournamentId,
            'status' => $match->status
        ];
    }
}