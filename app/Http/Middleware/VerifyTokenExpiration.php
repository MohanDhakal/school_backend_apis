<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($result = !$request->user()) {
            return response()->json(['message' => 'Unauthenticated user found'], 401);
        }
        $user = $request->user();
        $expiration = $request->user()->tokens()->where('name', $user->name)->latest()->first()->expires_at;
        if (now()->gte($expiration)) {
            return response()->json(['message' => 'Token expired.', 'token_id' => $user->currentAccessToken()->id], 401);
        }
        return $next($request);
    }
}
