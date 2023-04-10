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
        if (! $request->user() || $request->user()->tokenCan('expired')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $user=$request->user();
        // Log::info( json_encode($user->name));
        $expiration = $request->user()->tokens()->where('name',$user->name )->first()->expires_at;

        if (now()->gte($expiration)) {
            return response()->json(['message' => 'Token expired.'], 401);
        }

        return $next($request);    
    }
}
