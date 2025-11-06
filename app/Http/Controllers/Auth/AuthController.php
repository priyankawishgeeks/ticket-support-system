<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AppUser;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);
        // dd($request->all());
        $user = AppUser::where('email', $request->email)->first();
        // dd($user);  
        if (!$user) {
            return back()->withErrors(['email' => 'No account found for this email']);
        }

        if ($user->status !== 'Active') {
            return back()->withErrors(['email' => 'Account is inactive']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password']);
        }

        $expectedPanel = match ($request->role) {
            'admin' => 'A',
            'staff', 'agent' => 'S',
            default => 'S'
        };

        if ($user->panel !== $expectedPanel) {
            return back()->withErrors(['role' => 'Invalid role for this account']);
        }

        Auth::login($user);

        // ✅ Redirect by role
        return match ($user->panel) {
            'A' => redirect()->route('admin.dashboard'),
            'S' => redirect()->route('agent.dashboard'),
            default => redirect()->route('login')
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
