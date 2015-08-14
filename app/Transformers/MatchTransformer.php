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
            'round' => $match->round,
            'homeTeam' => $match->homeTournamentTeam->team->name,
            'homeTeamId' => $match->homeTournamentTeamId,
            'awayTeam' => $match->awayTournamentTeam->team->name,
            'awayTeamId' => $match->awayTournamentTeamId,
            'homeScore' => $match->homeScore,
            'awayScore' => $match->awayScore,
            'tournamentId' => $match->tournamentId,
            'status' => $match->status
        ];
    }
}