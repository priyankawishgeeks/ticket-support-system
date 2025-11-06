<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use App\Models\SiteUser;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with([ 'plan', 'siteUser'])->orderBy('created_at', 'desc')->get();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $users = User::all();
        $site_users = SiteUser::all();
        $plans = Plan::all();
        return view('admin.subscriptions.create', compact('users', 'plans', 'site_users'));
    }

    public function store(Request $request)
    {
        try {
            // Validate incoming data
            $validated = $request->validate([
                'user_id' => 'required|exists:site_user,id',
                'plan_id' => 'required|exists:plans,id',
                'status' => 'required|in:active,cancelled,expired,pending,trial',
                'amount' => 'required|min:0',
                'currency' => 'nullable|string|max:10',
                'payment_method' => 'nullable|string|max:50',
                'payment_reference' => 'nullable|string|max:100',
                'started_at' => 'nullable|date',
                'expires_at' => 'nullable|date',
                'trial_ends_at' => 'nullable|date',
                'cancelled_at' => 'nullable|date',
                'renewed_at' => 'nullable|date',
                'renewal_type' => 'nullable|in:auto,manual',
                'notes' => 'nullable|string',
                'meta' => 'nullable',
            ]);

            // Add defaults for missing values
            $data = array_merge($validated, [
                'currency' => $request->input('currency', 'USD'),
                'renewal_type' => $request->input('renewal_type', 'auto'),
            ]);

            // dd($data);
            // Create subscription
            Subscription::create($data);

            return redirect()
                ->route('admin.subscriptions.index')
                ->with('success', 'Subscription created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Redirect back with validation errors
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
          

            return redirect()
                ->back()
                ->with('error', 'An unexpected error occurred while creating the subscription. Please try again.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        $users = User::all();
        $plans = Plan::all();
        $site_users = SiteUser::all();
        $subscription = Subscription::findOrFail($id);
        return view('admin.subscriptions.edit', compact('subscription',  'plans', 'site_users'));
    }

  public function update(Request $request, $id)
{
    try {
        // Validate incoming data
        $validated = $request->validate([
            'user_id' => 'required|exists:site_user,id',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:active,cancelled,expired,pending,trial',
            'amount' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'payment_method' => 'nullable|string|max:50',
            'payment_reference' => 'nullable|string|max:100',
            'started_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'trial_ends_at' => 'nullable|date',
            'cancelled_at' => 'nullable|date',
            'renewed_at' => 'nullable|date',
            'renewal_type' => 'nullable|in:auto,manual',
            'notes' => 'nullable|string',
            'meta' => 'nullable',
        ]);

        // Find subscription or fail
        $subscription = Subscription::findOrFail($id);

        // Merge defaults for missing values
        $data = array_merge($validated, [
            'currency' => $request->input('currency', $subscription->currency ?? 'USD'),
            'renewal_type' => $request->input('renewal_type', $subscription->renewal_type ?? 'auto'),
        ]);

        // Update subscription
        $subscription->update($data);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('success', 'Subscription updated successfully.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Redirect back with validation errors
        return redirect()
            ->back()
            ->withErrors($e->validator)
            ->withInput();
    } catch (\Exception $e) {
        // Log for debugging (optional)

        return redirect()
            ->back()
            ->with('error', 'An unexpected error occurred while updating the subscription. Please try again.')
            ->withInput();
    }
}


    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription deleted successfully.');
    }
}
