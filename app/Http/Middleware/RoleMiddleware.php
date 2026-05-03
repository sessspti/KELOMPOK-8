<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            
            if ($request->user()) {
                $userRole = $request->user()->role;
                if ($userRole === 'seller') {
                    return redirect()->route('seller.dashboard');
                } elseif ($userRole === 'lembaga_sosial') {
                    return redirect()->route('sosial.dashboard');
                } elseif ($userRole === 'konsumen') {
                    return redirect()->route('dashboard');
                }
            }

            return redirect('/');
        }

        return $next($request);
    }
}
