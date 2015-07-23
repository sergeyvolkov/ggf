<?php

namespace App\Transformers;

use App\Models\Team;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];

    public function transform(Team $team)
    {
        return [
            'id' => $team->id,
            'leagueId' => $team->leagueId,
            'name' => $team->name,
            'logoPath' => $team->logoPath,
            'updated_at' => $team->updated_at->format('F d, Y')
        ];
    }
}