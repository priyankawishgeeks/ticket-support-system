<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SiteUser;

class SiteUserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.client_login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = SiteUser::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email']);
        }

        if ($user->status !== 'Active') {
            return back()->withErrors(['email' => 'Your account is inactive or suspended']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password']);
        }

        Auth::guard('site_user')->login($user);
        $user->update(['last_login_at' => now()]);

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('site_user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login')->with('success', 'You have been logged out successfully.');
    }
}
