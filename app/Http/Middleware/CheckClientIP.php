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
        if (\Auth::hasUser() || $request->url() == route('frontend.auth.login')
                || $request->url() == route('frontend.auth.login.post')) {
            return $next($request);
        }

        if (!app()->isLocal() && env('APP_BLOCK_IP', true)) {
            $ip = geoip()->getClientIP();
            $location = geoip()->getLocation($ip);
            if ($location['country'] != 'China') {
                return abort(233, "GeoIP check failed: " . $ip . " from " . $location['country']);
            }
        }
        return $next($request);
    }
}
