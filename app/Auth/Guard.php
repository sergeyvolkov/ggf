<?php

namespace App\Auth;

use App\Models\MemberToken;
use App\Models\Member;
use Facebook\FacebookSession;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookRequest;
use Facebook\GraphUser;

use Illuminate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request as HttpRequest;

class Guard extends Illuminate\Auth\Guard implements AuthContract
{
    /**
     * @param $code
     * @return null
     * @throws \Facebook\FacebookRequestException
     * @throws \Facebook\FacebookSDKException
     */
    protected function getAccessToken($code)
    {
        $response = (new FacebookRequest(
            FacebookSession::newAppSession(),
            'GET',
            '/oauth/access_token',
            [
                'client_id' => FacebookSession::_getTargetAppId(),
                'client_secret' => FacebookSession::_getTargetAppSecret(),
                'redirect_uri' => Config::get('auth.providers.facebook.redirect_uri'),
                'code' => $code
            ]
        ))->execute()->getResponse();

        // Graph v2.3 and greater return objects on the /oauth/access_token endpoint
        $accessToken = null;
        if (is_object($response) && isset($response->access_token)) {
            $accessToken = $response->access_token;
        } elseif (is_array($response) && isset($response['access_token'])) {
            $accessToken = $response['access_token'];
        }

        return $accessToken;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \FacebookFacebookAuthorizationException
     * @throws \Facebook\FacebookRequestException
     */
    public function facebookAuth($code)
    {
        $accessToken = $this->getAccessToken($code);

        $session = new FacebookSession($accessToken);

        if (!$session) {
            throw new FacebookAuthorizationException('Invalid code');
        }

        /**
         * @var GraphUser $userProfile
         */
        $userProfile = (new FacebookRequest(
            $session, 'GET', '/me'
        ))->execute()->getGraphObject(GraphUser::className());

        $user = Member::firstOrNew(['facebookId' => $userProfile->getId()]);
        $user->name = $userProfile->getName();
        $user->save();

        Auth::login($user);

        $memberToken = new MemberToken();
        $memberToken->memberId = $user->id;
        $memberToken->accessToken = $accessToken;
        $memberToken->sessionId = Session::getId();
        $memberToken->save();

        return $accessToken;
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        $user = $this->user();

        // If we have an event dispatcher instance, we can fire off the logout event
        // so any further processing can be done. This allows the developer to be
        // listening for anytime a user signs out of this application manually.
        $this->clearUserDataFromStorage();

        MemberToken::where(['sessionId' => Session::getId()])->delete();

        if (isset($this->events)) {
            $this->events->fire('auth.logout', [$user]);
        }

        // Once we have fired the logout event we will clear the users out of memory
        // so they are no longer available as the user is no longer considered as
        // being signed into this application and should not be available here.
        $this->user = null;

        $this->loggedOut = true;
    }

    /**
     *
     *
     * @param Request $request
     * return string
     */
    public static function getSessionId(HttpRequest $request)
    {
        $accessToken = trim(
            preg_replace('/^(?:\s+)?Bearer\s/', '', $request->header('Authorization'))
        );

        // find session with token
        $memberToken = MemberToken::where('accessToken', $accessToken)->first();

        if ($memberToken && Session::isValidId($memberToken->sessionId)) {
            /**
             * @var MemberToken $memberToken
             */
            $memberToken->update([
                'updated_at' => $memberToken->freshTimestamp()
            ]);
            return $memberToken->sessionId;
        } else {
            return $request->cookies->get(Session::getName());
        }
    }
}