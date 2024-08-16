<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class SecurityApps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (empty($request->header('SECURITY_REQ'))) {
            return response()->json(['message' => 'security invalid'], 401);
        }

        try {
            if (!empty($request->header('SECURITY_REQ'))) {

                $CheckSecurity = Hash::check($request->header('SECURITY_REQ'), env('SECURITY_KEY'));
                if (!$CheckSecurity) {
                    return response()->json(['message' => 'security invalid'], 401);
                }

                if ($CheckSecurity) {
                    return $next($request);
                }
            }
        } catch (\Exception) {
            return response()->json(['message' => 'security check wrong, please try again'], 401);
        }
    }
}
