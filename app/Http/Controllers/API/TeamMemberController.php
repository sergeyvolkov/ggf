<?php

namespace App\Http\Controllers\API;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class TeamMemberController extends Controller
{
    public function catalogue()
    {
        return [
            'teamMembers' => [
//                ['id' => 1, 'name' => 'John Doe', 'teamId' => Input::get('teamId')],
//                ['id' => 2, 'name' => 'Jane Doe', 'teamId' => Input::get('teamId')]
            ]
        ];
    }
}
