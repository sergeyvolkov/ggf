<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateLeague;
use App\Models\League;
use App\Transformers\LeagueTransformer;
use App\Transformers\TeamTransformer;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

class LeagueController extends Controller
{
    public function catalogue()
    {
        return $this->response->collection(League::all(), new LeagueTransformer($this->response), 'leagues');
    }

    /**
     * Create new league
     *
     * @param CreateLeague $request
     * @return array
     */
    public function store(CreateLeague $request)
    {
        $league = League::create($request->input('league'));

        return $this->response->collection(League::where(['id' => $league->id])->get(), new LeagueTransformer(), 'leagues');
    }

    /**
     * @return array
     */
    public function teams()
    {
        $collection = League::find(Input::get('leagueId'))->teams();

        return $this->response->collection($collection->get(), new TeamTransformer(), 'leagueTeams');
    }
}