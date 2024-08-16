<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetSecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $response = $next($request);
        // $response->header('SECURITY_APPS', env('SECURITY_KEY'));
        // return $response;

        $request->headers->set('SECURITY_REQ', env('SECURITY_REQ'));
        return $next($request);
    }
}
