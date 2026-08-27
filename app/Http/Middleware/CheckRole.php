<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Get the authenticated user's role
        $userRole = auth()->user()->role;

        // If roles are specified and user's role is not in the allowed roles
        if (!empty($roles) && !in_array($userRole, $roles)) {
            // Redirect to dashboard with error message
            return redirect('/dashboard')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}

