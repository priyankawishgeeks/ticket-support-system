<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $roleMap = [
            'admin' => 'A',
            'agent' => 'S',
        ];

        $allowedPanels = collect($roles)->map(fn($r) => $roleMap[$r] ?? null);

        if (!$allowedPanels->contains($user->panel)) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}
