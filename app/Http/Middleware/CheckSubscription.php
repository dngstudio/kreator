<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    public function handle(Request $request, Closure $next, $creatorId)
    {
        $user = Auth::user();
        $creator = User::find($creatorId);

        if (!$user->subscriptions->contains($creator)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}

