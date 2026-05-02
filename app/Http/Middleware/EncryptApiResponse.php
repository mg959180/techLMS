<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EncryptApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $crypto = app('crypto');

        return response()->json([
            'payload' => $crypto->encrypt($response->getData(true))
        ]);
    }
}
