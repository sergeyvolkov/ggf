<?php

namespace App\Http\Controllers\API;

use App\Models\Tournament;
use App\Transformers\TournamentTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;

class TournamentController extends Controller
{
    public function catalogue()
    {
        return $this->response->collection(Tournament::all(), new TournamentTransformer(), 'tournaments');
    }
}
