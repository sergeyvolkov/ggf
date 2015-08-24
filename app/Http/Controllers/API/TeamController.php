<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Tournament\RemoveTeam;
use App\Models\Team;
use App\Models\TournamentTeam;
use App\Transformers\TeamSearchTransformer;
use App\Transformers\TournamentTeamTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class TeamController extends Controller
{
    public function find($teamId)
    {
        $collection = TournamentTeam::where(['id' => $teamId]);

        return $this->response->collection($collection->get(), new TournamentTeamTransformer(), 'teams');
    }

    public function search()
    {
        $collection = Team::with('tournamentTeams.tournament')->where('name', 'like', Input::get('term') . '%')->get();

        return $this->response->collection(
            $collection,
            new TeamSearchTransformer(),
            'teams'
        );
    }

    public function remove($teamId, RemoveTeam $request)
    {
        return TournamentTeam::where(['id' => $teamId])->delete();
    }
}