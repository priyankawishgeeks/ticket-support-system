<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\Ticket;
use App\Models\Plan;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::guard('site_user')->user();

        $subscription = Subscription::with('plan')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        $assignedtickets = Ticket::where('ticket_user', $user->id)->count();
        $closedTickets = Ticket::where('ticket_user', $user->id)->where('status', ['Closed'])->count();
        $activeTickets = Ticket::where('ticket_user', $user->id)->whereNotIn('status', ['Closed'])->count();




        return view('user.dashboard', compact('user', 'subscription', 'activeTickets', 'closedTickets', 'assignedtickets'));
    }
    public function profile()
    {
        $user = Auth::guard('site_user')->user();
        // dd($user);  
        $subscription = Subscription::with('plan')
            ->where('user_id', $user->id)
            ->latest()
            ->first();
        // $subscription = $user->subscription()->with('plan')->latest()->first();

        $plans = Plan::all(); // optional, display user plans

        return view('user.profile', compact('user', 'subscription', 'plans'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('site_user')->user();

        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:site_user,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'photo_url' => 'nullable|image|max:2048',
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
        ]);

        // Handle profile image upload
        if ($request->hasFile('photo_url')) {
            $path = $request->file('photo_url')->store('profiles', 'public');
            $data['photo_url'] = $path;
        }

        $user->update($data);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        return view('user.change_password');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::guard('site_user')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Your current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }


    public function contactSupport()
{
    $user = Auth::guard('site_user')->user();

    // Load all active (non-closed) tickets with assigned agent info
    $tickets = Ticket::with(['assignee' => function ($q) {
        $q->select('id', 'user', 'email', 'contact_number', 'img_url');
    }])
    ->where('ticket_user', $user->id)
    ->where('status', '!=', 'Closed')
    ->latest()
    ->get();

    return view('user.contact_support', compact('tickets'));
}

}
