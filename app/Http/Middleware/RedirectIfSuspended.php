<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfSuspended
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && !is_null($user->suspension_reason)) {
            if (!$request->routeIs('verification.*') && !$request->routeIs('logout')) {
                return redirect()->route('verification.notice');
            }
        }

        return $next($request);
    }
}
