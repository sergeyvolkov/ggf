<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function signOut()
    {
        /**
         * @var Session $session
         */
        $session = Auth::getSession();

        $session->clear();

        return response()->json(['status' => 200]);
    }
}
