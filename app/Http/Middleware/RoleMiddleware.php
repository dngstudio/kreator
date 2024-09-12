<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $roles = explode('|', $roles); // Split roles by '|'

        // Check if user has any of the specified roles
        foreach ($roles as $role) {
            if ($user->isAn($role)) {
                return $next($request);
            }
        }

        // If none of the roles match, return a 403 response
        abort(403, 'Unauthorized access.');
    }
}
