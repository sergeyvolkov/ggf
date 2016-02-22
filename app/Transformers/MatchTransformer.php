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
            'homeTeam' => $match->homeTournamentTeamId,
            'homeTeamId' => $match->homeTournamentTeamId,
            'awayTeam' => $match->awayTournamentTeamId,
            'awayTeamId' => $match->awayTournamentTeamId,
            'homeScore' => $match->homeScore,
            'homePenaltyScore' => $match->homePenaltyScore,
            'awayScore' => $match->awayScore,
            'awayPenaltyScore' => $match->awayPenaltyScore,
            'tournamentId' => $match->tournamentId,
            'status' => $match->status
        ];
    }
}