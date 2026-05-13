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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect('/login');
        }

        $userRole = $user->role;
        
        // Normalize roles
        $allowedRoles = [];
        foreach ($roles as $role) {
            $parts = explode(',', $role);
            foreach ($parts as $part) {
                $allowedRoles[] = trim($part);
            }
        }

        if (!in_array($userRole, $allowedRoles)) {
            if ($userRole === 'seller') {
                return redirect()->route('seller.dashboard');
            } elseif ($userRole === 'lembaga_sosial') {
                return redirect()->route('sosial.dashboard');
            } elseif ($userRole === 'konsumen') {
                return redirect()->route('dashboard');
            }
            return redirect('/');
        }

        return $next($request);
    }
}
