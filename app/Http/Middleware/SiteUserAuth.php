<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteUserAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('site_user')->check()) {
            return redirect()->route('client.login')->with('error', 'Please login to access your dashboard.');
        }

        return $next($request);
    }
}
