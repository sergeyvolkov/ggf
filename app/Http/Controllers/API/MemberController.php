<?php

namespace App\Http\Controllers\API;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function current()
    {
        return response()->json(Auth::user());
    }
}
