<?php

namespace App\Http\Controllers\API;

use App\Models\Match;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Transformers\TournamentTransformer;
use App\Transformers\MatchTransformer;
use App\Transformers\TournamentTeamTransformer;

use App\Http\Requests;
use Illuminate\Support\Facades\Request;

class TournamentController extends Controller
{
    public function catalogue()
    {
        $collection = Tournament::with('tournamentTeams.team');

        return $this->response->collection($collection->get(), new TournamentTransformer($this->response), 'tournaments');
    }

    public function matches()
    {
        $collection = Match::with(['homeTournamentTeam.team', 'awayTournamentTeam.team'])->where(['tournamentId' => Request::get('tournamentId')]);

        return $this->response->collection($collection->get(), new MatchTransformer(), 'matches');
    }

    public function teams()
    {
        $collection = TournamentTeam::with('Team')->where(['tournamentId' => Request::get('tournamentId')]);

        return $this->response->collection($collection->get(), new TournamentTeamTransformer(), 'teams');
    }
}
