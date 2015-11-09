<?php

namespace App\Http\Controllers\API;

use App\Models\Match;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Serializers\Tournament\TablescoresSerializer;
use App\Transformers\TournamentTransformer;
use App\Transformers\MatchTransformer;
use App\Transformers\TablescoresTransformer;

use App\Http\Requests\Tournament\Create as CreateTournament;
use Illuminate\Support\Collection;
use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use League\Fractal\Manager;
use Sorskod\Larasponse\Larasponse;


class TournamentController extends Controller
{
    public function __construct(Larasponse $response)
    {
        $this->response = $response;

        $this->middleware('auth', ['only' => ['update']]);
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

    public function tablescores()
    {
        $serializer = new TablescoresSerializer();

        $collection = Match::with(['homeTournamentTeam.team', 'awayTournamentTeam.team'])
            ->where(['tournamentId' => Input::get('tournamentId')]);

        return $this->response->collection(
            $serializer->collection($collection->get()),
            new TablescoresTransformer(),
            'tablescore'
        );
    }

    public function standings()
    {
        return [
            'standings' => []
        ];
    }

    /**
     * Create new tournament
     *
     * @param CreateTournament $request
     * @return array
     */
    public function store(CreateTournament $request)
    {
        $input = $request->input('tournament');
        $input['status'] = Tournament::STATUS_DRAFT;

        $tournament = Tournament::create($input);

        return $this->response->collection(Tournament::where(['id' => $tournament->id])->get(), new TournamentTransformer($this->response), 'tournaments');
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
            'status' => Input::get('tournament.status'),
            'membersType' => Input::get('tournament.membersType'),
            'description' => Input::get('tournament.description')
        ]);

        return $this->response->collection(Tournament::where(['id' => $tournamentId])->get(), new TournamentTransformer(), 'tournaments');
    }
}
