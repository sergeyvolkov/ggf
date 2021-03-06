<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Auth\Guard;


use Facebook\FacebookSession;
use Illuminate\Support\Facades\Session;

// add other classes you plan to use, e.g.:
// use Facebook\FacebookRequest;
// use Facebook\GraphUser;
// use Facebook\FacebookRequestException;

/**
 * Class FacebookController
 *
 * @package App\Http\Controllers\Auth
 */
class FacebookController extends Controller
{
    public function token(Guard $auth)
    {
        try {
            $accessToken = $auth->facebookAuth(Input::get('code'));

            return response()->json([
                'user' => [
                    'name' => Auth::user()->name,
                    'facebookId' => Auth::user()->facebookId,
                    'id' => Auth::user()->id
                ],
                'token_type' => 'bearer',
                'access_token' => $accessToken
            ]);

        } catch(\Exception $e) {
            Log::error(
                "Exception occured, code: " . $e->getCode()
                . " with message: " . $e->getMessage()
            );
        }

        return response('Bad request.', 400);
    }
}
