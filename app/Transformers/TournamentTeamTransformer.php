<?php

namespace App\Transformers;

use App\Models\TournamentTeam;
use League\Fractal\TransformerAbstract;

class TournamentTeamTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];

    public function transform(TournamentTeam $tournamentTeam)
    {
        return [
            'id' => $tournamentTeam->id,
            'name' => $tournamentTeam->team->name,
            'logoPath' => $tournamentTeam->team->logoPath,
            'tournamentId' => $tournamentTeam->tournamentId,
            'teamId' => $tournamentTeam->team->id,
            'updated_at' => $tournamentTeam->team->updated_at->format('F d, Y')
        ];
    }
}