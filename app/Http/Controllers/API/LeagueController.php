<?php

namespace App\Http\Controllers\API;

use App\Models\League;
use App\Transformers\LeagueTransformer;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

class LeagueController extends Controller
{
    public function catalogue()
    {
        return $this->response->collection(League::all(), new LeagueTransformer($this->response), 'leagues');
    }

    // @todo This is tmp code just to make it works
    public function addLeague()
    {
        $league = League::firstOrNew([
            'name' => Input::get('league.name'),
            'logoPath' => Input::get('league.logoPath')
        ]);
        $league->save();

        return $this->response->collection(League::where(['id' => $league->id])->get(), new LeagueTransformer(), 'leagues');
    }
}