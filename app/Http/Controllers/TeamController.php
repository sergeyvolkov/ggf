<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $teams = Team::all();

        return view('team.index', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        Team::create(Request::all());

        return redirect('team');
    }
}