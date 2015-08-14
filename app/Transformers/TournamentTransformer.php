<?php

namespace App\Transformers;

use App\Models\Tournament;
use League\Fractal\TransformerAbstract;

class TournamentTransformer extends TransformerAbstract
{
    public function transform(Tournament $tournament)
    {
        $teams = [];

        foreach ($tournament->tournamentTeams as $tournamentTeam) {
            $teams[] = $tournamentTeam->id;
        }

        return [
            'id' => $tournament->id,
            'name' => $tournament->name,
            'status' => $tournament->status,
            'type' => $tournament->type,
            'membersType' => $tournament->membersType,
            'teams' => $teams,
            'description' => $tournament->description,
            'updated_at' => $tournament->updated_at->format('F d, Y')
        ];
    }
}