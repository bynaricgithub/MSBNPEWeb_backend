<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiryForAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('api')->check()) {
            $token = $request->user()->token();

            // Check if token has expired
            if (Carbon::parse($token->expires_at)->isPast()) {
                // Token expired, revoke it
                $token->revoke();

                return response()->json([
                    'message' => 'Token has expired',
                ], 401);
            }

            // Check user's role
            /* if ($request->user()->role !== '1') {
                return response()->json([
                    'message' => 'Unauthorized access',
                ], 403);
            } */
        }

        return $next($request);
    }
}
