<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && in_array($user->role, ['seller', 'lembaga_sosial'])) {
            if ($user->account_status === 'pending' || $user->account_status === 'rejected') {
                if (! $request->routeIs('verification.*') && ! $request->routeIs('logout')) {
                    return redirect()->route('verification.notice');
                }
            }
        }

        return $next($request);
    }
}
