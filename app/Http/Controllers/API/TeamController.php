<?php

namespace App\Http\Controllers\API;

use App\Models\Team;
use App\Models\TournamentTeam;
use App\Transformers\TournamentTeamTransformer;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class TeamController extends Controller
{
    public function find($teamId)
    {
        $collection = TournamentTeam::with('Team')->where(['id' => $teamId]);

        return $this->response->collection($collection->get(), new TournamentTeamTransformer(), 'teams');
    }
}