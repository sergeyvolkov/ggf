<?php

namespace App\Http\Controllers\API;

use App\Models\League;
use App\Transformers\LeagueTransformer;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class LeagueController extends Controller
{
    public function catalogue()
    {
        return $this->response->collection(League::all(), new LeagueTransformer($this->response), 'leagues');
    }
}