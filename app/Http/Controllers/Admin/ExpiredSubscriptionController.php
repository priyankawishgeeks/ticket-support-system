<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpiredSubscription;
use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class ExpiredSubscriptionController extends Controller
{
    public function index()
    {
        $expiredSubscriptions = ExpiredSubscription::with(['user', 'plan', 'subscription'])
            ->latest()
            ->paginate(10);

        return view('admin.expired_subscriptions.index', compact('expiredSubscriptions'));
    }

    public function create()
    {
        $users = User::all();
        $plans = Plan::all();
        $subscriptions = Subscription::all();

        return view('admin.expired_subscriptions.create', compact('users', 'plans', 'subscriptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subscription_id' => 'nullable|exists:subscriptions,id',
            'plan_id' => 'nullable|exists:plans,id',
            'plan_title' => 'nullable|string|max:150',
            'plan_slug' => 'nullable|string|max:100',
            'currency' => 'nullable|string|max:10',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:expired,cancelled,grace_period,renewal_failed,archived',
        ]);

        ExpiredSubscription::create($validated + [
            'expired_at' => now(),
        ]);

        return redirect()->route('admin.expired_subscriptions.index')
            ->with('success', 'Expired subscription created successfully.');
    }

    public function edit($id)
    {
        $expiredSubscription = ExpiredSubscription::findOrFail($id);
        $users = User::all();
        $plans = Plan::all();
        $subscriptions = Subscription::all();

        return view('admin.expired_subscriptions.edit', compact('expiredSubscription', 'users', 'plans', 'subscriptions'));
    }

    public function update(Request $request, $id)
    {
        $expiredSubscription = ExpiredSubscription::findOrFail($id);

        $validated = $request->validate([
            'plan_title' => 'nullable|string|max:150',
            'plan_slug' => 'nullable|string|max:100',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:expired,cancelled,grace_period,renewal_failed,archived',
            'expiry_reason' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ]);

        $expiredSubscription->update($validated);

        return redirect()->route('admin.expired_subscriptions.index')
            ->with('success', 'Expired subscription updated successfully.');
    }

    public function destroy($id)
    {
        $expiredSubscription = ExpiredSubscription::findOrFail($id);
        $expiredSubscription->delete();

        return redirect()->route('admin.expired_subscriptions.index')
            ->with('success', 'Expired subscription deleted successfully.');
    }
}
