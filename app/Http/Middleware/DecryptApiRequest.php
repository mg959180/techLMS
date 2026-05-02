<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DecryptApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->payload) {
            $crypto = app('crypto');
            $data = $crypto->decrypt($request->payload);

            $request->merge($data);
        }
        
        return $next($request);
    }
}
