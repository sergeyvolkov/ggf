<?php

namespace App\Http\Controllers\API;

use App\Models\Match;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Transformers\TournamentTransformer;
use App\Transformers\MatchTransformer;
use App\Transformers\TournamentTeamTransformer;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Sorskod\Larasponse\Larasponse;


class TournamentController extends Controller
{
    public function __construct(Larasponse $response)
    {
        $this->response = $response;

        $this->middleware('auth', ['only' => ['update', 'addTeam']]);
    }

    public function catalogue()
    {
        $collection = Tournament::with('tournamentTeams.team');

        return $this->response->collection($collection->get(), new TournamentTransformer($this->response), 'tournaments');
    }

    public function find($tournamentId)
    {
        $collection = Tournament::with('tournamentTeams.team')->where(['id' => $tournamentId]);

        return $this->response->collection($collection->get(), new TournamentTransformer($this->response), 'tournaments');
    }

    public function matches()
    {
        $collection = Match::with(['homeTournamentTeam.team', 'awayTournamentTeam.team'])
            ->where(['tournamentId' => Input::get('tournamentId')]);

        return $this->response->collection($collection->get(), new MatchTransformer(), 'matches');
    }

    public function teams()
    {
        $collection = TournamentTeam::with('Team')->where(['tournamentId' => Input::get('tournamentId')]);

        return $this->response->collection($collection->get(), new TournamentTeamTransformer(), 'teams');
    }

    public function update($tournamentId)
    {
        /**
         * @var Tournament $tournament
         */
        $tournament = Tournament::findOrFail($tournamentId);
        $tournament->update([
            'name' => Input::get('tournament.name'),
            'type' => Input::get('tournament.type'),
            'membersType' => Input::get('tournament.membersType'),
            'description' => Input::get('tournament.description')
        ]);

        return $this->response->collection(Tournament::where(['id' => $tournamentId])->get(), new TournamentTransformer(), 'tournaments');
    }

    // @todo This is tmp code just to make it works
    public function addTeam()
    {
        $tournament = Tournament::findOrFail(Input::get('team.tournamentId'));

        $team = Team::firstOrNew([
            'name' => Input::get('team.name')
        ]);
        $team->logoPath = '';
        $team->save();

        $tournamentTeam = TournamentTeam::create([
            'teamId' => $team->id,
            'tournamentId' => $tournament->id
        ]);

        return $this->response->collection(TournamentTeam::where(['id' => $tournamentTeam->id])->get(), new TournamentTeamTransformer(), 'teams');
    }
}
