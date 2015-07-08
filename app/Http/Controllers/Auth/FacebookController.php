<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Auth\Guard;


use Facebook\FacebookSession;
// add other classes you plan to use, e.g.:
// use Facebook\FacebookRequest;
// use Facebook\GraphUser;
// use Facebook\FacebookRequestException;


class FacebookController extends Controller
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var Guard
     */
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->config = Config::get('auth.providers.facebook');
    }

    public function token()
    {
        Log::info(Request::all());

        $appId = array_get($this->config, 'app_id');
        $appSecret = array_get($this->config, 'app_secret');

        $params = array(
            'client_id' => $appId,
            'redirect_uri' => array_get($this->config, 'redirect_uri'),
            'client_secret' => $appSecret,
            'code' => Request::get('code')
        );

        FacebookSession::setDefaultApplication($appId, $appSecret);

        $response = (new FacebookRequest(
            FacebookSession::newAppSession(),
            'GET',
            '/oauth/access_token',
            $params
        ))->execute()->getResponse();

        // Graph v2.3 and greater return objects on the /oauth/access_token endpoint
        $accessToken = null;
        if (is_object($response) && isset($response->access_token)) {
            $accessToken = $response->access_token;
        } elseif (is_array($response) && isset($response['access_token'])) {
            $accessToken = $response['access_token'];
        }
        if (isset($accessToken)) {
            $session = new FacebookSession($accessToken);
        }

        if($session) {
            try {
                /**
                 * @var GraphUser $userProfile
                 */
                $userProfile = (new FacebookRequest(
                    $session, 'GET', '/me'
                ))->execute()->getGraphObject(GraphUser::className());

                $user = Member::firstOrNew(['facebookId' => $userProfile->getId()]);
                $user->name = $userProfile->getName();
                $user->save();

                $this->auth->login($user);

                return response()->json([
                    'user' => [
                        'name' => $user->name,
                        'id' => $user->facebookId
                    ],
                    'access_token' => $accessToken
                ]);

            } catch(FacebookRequestException $e) {
                Log::error(
                    "Exception occured, code: " . $e->getCode()
                        . " with message: " . $e->getMessage()
                );
            }
        }

        return response('Unauthorized.', 401);
    }
}
