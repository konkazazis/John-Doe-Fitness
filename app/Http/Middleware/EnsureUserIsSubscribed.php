<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsSubscribed
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || ! $request->user()->hasActiveSubscription()) {
            return redirect()->route('user.my-subscription');
        }

        return $next($request);
    }
}
