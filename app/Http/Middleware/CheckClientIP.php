<?php

namespace App\Http\Middleware;

use Closure;

class CheckClientIP
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
        if (!app()->isLocal() && env('APP_BLOCK_IP', true)) {
            $location = geoip()->getLocation(geoip()->getClientIP());
            if ($location['country'] != 'China') {
                return abort(451, 'Bad client country: ' . $location['country']);
            }
        }
        return $next($request);
    }
}
