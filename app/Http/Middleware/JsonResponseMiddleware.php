<?php

namespace App\Http\Middleware;

use Closure;

class JsonResponseMiddleware
{
    /**
     * Handle an incoming request.
     * Forces the Accept header to JSON.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
