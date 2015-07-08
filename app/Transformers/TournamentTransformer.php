<?php

namespace App\Transformers;

use App\Models\Tournament;
use League\Fractal\TransformerAbstract;

class TournamentTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];

    public function transform(Tournament $tournament)
    {
        return [
            'id' => $tournament->id,
            'name' => $tournament->name,
            'description' => $tournament->description,
            'updated_at' => $tournament->updated_at->format('F d, Y')
        ];
    }
}