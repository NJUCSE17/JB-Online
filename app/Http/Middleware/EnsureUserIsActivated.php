<?php

namespace App\Http\Middleware;

use Closure;

class EnsureUserIsActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->isActive()) {
            return redirect('activation');
        }

        return $next($request);
    }
}