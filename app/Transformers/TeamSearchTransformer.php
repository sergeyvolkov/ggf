<?php

namespace App\Transformers;

use App\Models\Team;
use League\Fractal\TransformerAbstract;

class TeamSearchTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];

    public function transform(Team $team)
    {
        return [
            'id' => $team->id,
            'text' => $team->name,
            'logoPath' => $team->logoPath,
            'updated_at' => $team->updated_at->format('F d, Y')
        ];
    }
}