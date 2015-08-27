<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateLeague;
use App\Models\League;
use App\Models\Match;
use App\Transformers\LeagueTransformer;
use App\Transformers\MatchTransformer;
use App\Transformers\TeamTransformer;
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
}