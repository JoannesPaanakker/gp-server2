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
        if(!env('APP_LOG_REQUESTS'))return $next($request);

        error_log('##### New Request: (' . $request->method() . ') ' . $request->fullUrl());
        error_log('PARAMS:');
        error_log(print_r($request->all(), 1);

        $response = $next($request);
        error_log('---------------- Response --------------------');
        error_log($response);
        error_log("\n\n");
        
        return $response;
    }
}
