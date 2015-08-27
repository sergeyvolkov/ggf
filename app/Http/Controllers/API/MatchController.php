<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateLeague;
use App\Http\Requests\MatchUpdate;
use App\Models\League;
use App\Models\Match;
use App\Transformers\LeagueTransformer;
use App\Transformers\MatchTransformer;
use App\Transformers\TeamTransformer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

class MatchController extends Controller
{
    public function catalogue()
    {
        $teamId = Input::get('teamId');
        $status = Input::get('status');

        $collection = Match::with(['homeTournamentTeam.team', 'awayTournamentTeam.team'])
            ->where('tournamentId', Input::get('tournamentId'))
            ->orderBy('round')->orderBy('id');

        if ($status) {
            $collection->where('status', $status);
        }

        if ($teamId) {
            $collection->where(function($query) use ($teamId) {
                $query->where('homeTournamentTeamId', $teamId)
                    ->orWhere('awayTournamentTeamId', $teamId);
            });
        }

        return $this->response->collection($collection->get(), new MatchTransformer(), 'matches');
    }

    public function update($matchId, MatchUpdate $request)
    {
        /**
         * @var $match Match
         */
        $match = Match::findOrFail($matchId);
        $match->update($request->get('match'));

        return $this->response->collection(Match::where(['id' => $request->get('id')]), new MatchTransformer(), 'matches');
    }
}