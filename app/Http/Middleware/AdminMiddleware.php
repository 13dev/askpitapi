<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminMiddleware
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
        // Pre-Middleware Action
        $payload = JWTAuth::parseToken()->getPayload();

        //check if user has collum admin == 1
        if($payload->get('admin'))
        {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}
