<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $members = Member::all();

        return view('member.index', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        Member::create(Request::all());

        return redirect('member');
    }
}