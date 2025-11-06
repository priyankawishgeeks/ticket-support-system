<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Show checkout page for selected plan
     */
    public function index($planId)
    {
        $plan = Plan::findOrFail($planId);
        return view('user.checkout', compact('plan'));
    }

    /**
     * Handle subscription and create record
     */
    public function subscribe(Request $request, $planId)
    {
        $plan = Plan::findOrFail($planId);
        $user = Auth::guard('site_user')->user();

        // Calculate trial or regular period
        $startDate = now();
        $trialEnds = $plan->trial_days > 0 ? now()->addDays($plan->trial_days) : null;
        $expireDate = $trialEnds ?? now()->addDays($plan->duration_days);

        // Create subscription
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => $plan->trial_days > 0 ? 'trial' : 'active',
            'amount' => $plan->price,
            'currency' => $plan->currency ?? 'INR',
            'payment_method' => 'manual', // or online if using Razorpay/Stripe later
            'payment_reference' => strtoupper(uniqid('SUB-')),
            'started_at' => $startDate,
            'trial_ends_at' => $trialEnds,
            'expires_at' => $expireDate,
            'renewal_type' => $plan->renewal_type ?? 'auto',
            'notes' => 'Subscribed to ' . $plan->title,
        ]);

        return redirect()->route('client.checkout.success', $subscription->id)
            ->with('success', 'Subscription created successfully!');
    }

    /**
     * Success page
     */
    public function success($id)
    {
        $subscription = Subscription::with('plan')->findOrFail($id);
        return view('user.checkout_success', compact('subscription'));
    }
}
