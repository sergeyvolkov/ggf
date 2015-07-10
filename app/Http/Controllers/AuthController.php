<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

class AuthController extends Controller
{
    public function logout(Guard $auth)
    {
        $auth->logout();

        return response()->json(['status' => 200]);
    }
}
