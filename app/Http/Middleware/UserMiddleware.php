<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CreatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->tokenCan('creator'))
            return $next($request);
        else
            return send_response(false,'only User can access this route',null,401);
    }
}
