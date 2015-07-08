<?php

namespace App\Http\Middleware;

use Closure;

class AllowOrigin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            $origin = $_SERVER['HTTP_ORIGIN'];

            // @todo Move list of allow origins to config
            if (in_array($origin, ['http://localhost:4200'])) {
                header("Access-Control-Allow-Origin: $origin");
                header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
                header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
                header('Access-Control-Allow-Credentials: true');
            }
        }

        return $next($request);
    }
}
