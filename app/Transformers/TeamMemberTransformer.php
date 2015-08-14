<?php

namespace App\Transformers;

use App\Models\TeamMember;
use League\Fractal\TransformerAbstract;

class TeamMemberTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];

    public function transform(TeamMember $teamMember)
    {
        return [
            'id' => $teamMember->id,
            'name' => $teamMember->member->name,
            'teamId' => $teamMember->tournamentTeamId,
            'memberId' => $teamMember->memberId,
            'team' => $teamMember->tournamentTeamId
        ];
    }
}