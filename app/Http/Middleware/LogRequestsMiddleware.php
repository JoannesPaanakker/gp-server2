<?php

namespace App\Http\Middleware;

use Closure;

class LogRequestsMiddleware
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
        
        error_log('----- New Request: ' . $request->fullUrl());
        return $next($request);
    }
}
