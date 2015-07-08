<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function facebookToken()
    {
        $input = Request::all();

        Log::info($input);

        return ['user' => ["id" => "559ae1a8b9570e8339932bbf","name" => "Pavel Machekhin"], 'access_token' => 'secret'];
    }
}
