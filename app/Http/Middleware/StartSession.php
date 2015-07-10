<?php

namespace App\Http\Middleware;

use App\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Closure;

class StartSession extends \Illuminate\Session\Middleware\StartSession
{
    protected $auth;

    /**
     * Create a new session middleware.
     *
     * @param  \Illuminate\Session\SessionManager  $manager
     * @return void
     */
    public function __construct(SessionManager $manager, Guard $auth)
    {
        $this->manager = $manager;
        $this->auth = $auth;
    }

    /**
     * @inheritdoc
     */
    public function getSession(Request $request)
    {
        $session = $this->manager->driver();
        $session->setId($this->getSessionId($request, $session));

        return $session;
    }

    /**
     * @param Request $request
     * @param $session
     * @return mixed
     */
    protected function getSessionId(Request $request, $session)
    {
        return $this->auth->getSessionId($request);
    }

    /**
     * Handle an incoming request, but skip OPTIONS method
     *
     * @inheritdoc
     */
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('options')) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
