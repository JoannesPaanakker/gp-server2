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
        error_log('##### New Request: ' . $request->fullUrl());
        $response = $next($request);
        error_log('---------------- Response --------------------');
        error_log($response);
        error_log("\n\n");
        return $response;
    }
}
