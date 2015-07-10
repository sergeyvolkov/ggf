<?php

namespace App\Http\Middleware;

use App\Models\MemberToken;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AuthWithToken
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Skip already logged in user
        if ($this->auth->user()) {
            return $next($request);
        }

        // Skip OPTIONS request
        if ($request->isMethod('options')) {
            return $next($request);
        }

        $accessToken = trim(preg_replace('/^(?:\s+)?Bearer\s/', '', $request->header('Authorization')));

        // find session with token
        $memberToken = MemberToken::where('accessToken', $accessToken)->first();

        if ($memberToken && Session::isValidId($memberToken->sessionId)) {
            // renew session
            Session::setId($memberToken->sessionId);
            Session::start();
        }

        return $next($request);
    }
}
