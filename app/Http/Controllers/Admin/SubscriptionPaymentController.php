<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPayment;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionPaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index()
    {
        $payments = SubscriptionPayment::with(['user', 'plan', 'subscription'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.subscription_payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $users = User::all();
        $plans = Plan::all();
        $subscriptions = Subscription::all();

        return view('admin.subscription_payments.create', compact('users', 'plans', 'subscriptions'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'subscription_id'   => 'required|exists:subscriptions,id',
            'plan_id'           => 'required|exists:plans,id',
            'amount'            => 'required|numeric|min:0',
            'currency'          => 'nullable|string|max:10',
            'payment_method'    => 'nullable|string|max:50',
            'payment_reference' => 'nullable|string|max:150',
            'invoice_number'    => 'nullable|string|max:100',
            'payment_intent_id' => 'nullable|string|max:150',
            'status'            => 'required|string',
            'payment_type'      => 'required|string',
            'renewal_attempt'   => 'nullable|boolean',
            'payment_due_at'    => 'nullable|date',
            'paid_at'           => 'nullable|date',
            'refunded_at'       => 'nullable|date',
            'next_retry_at'     => 'nullable|date',
            'retry_count'       => 'nullable|integer|min:0',
            'max_retries'       => 'nullable|integer|min:0',
            'gateway_response'  => 'nullable',
            'meta'              => 'nullable',
            'notes'             => 'nullable|string',
        ]);

        // Normalize checkbox
        $validated['renewal_attempt'] = $request->has('renewal_attempt');

        SubscriptionPayment::create($validated);

        return redirect()->route('admin.subscription_payments.index')
            ->with('success', 'Payment created successfully.');
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit($id)
    {
        $payment = SubscriptionPayment::findOrFail($id);
        $users = User::all();
        $plans = Plan::all();
        $subscriptions = Subscription::all();

        return view('admin.subscription_payments.edit', compact('payment', 'users', 'plans', 'subscriptions'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'subscription_id'   => 'required|exists:subscriptions,id',
            'plan_id'           => 'required|exists:plans,id',
            'amount'            => 'required|numeric|min:0',
            'currency'          => 'nullable|string|max:10',
            'payment_method'    => 'nullable|string|max:50',
            'payment_reference' => 'nullable|string|max:150',
            'invoice_number'    => 'nullable|string|max:100',
            'payment_intent_id' => 'nullable|string|max:150',
            'status'            => 'required|string',
            'payment_type'      => 'required|string',
            'renewal_attempt'   => 'nullable|boolean',
            'payment_due_at'    => 'nullable|date',
            'paid_at'           => 'nullable|date',
            'refunded_at'       => 'nullable|date',
            'next_retry_at'     => 'nullable|date',
            'retry_count'       => 'nullable|integer|min:0',
            'max_retries'       => 'nullable|integer|min:0',
            'gateway_response'  => 'nullable|json',
            'meta'              => 'nullable|json',
            'notes'             => 'nullable|string',
        ]);

        $validated['renewal_attempt'] = $request->has('renewal_attempt');

        $payment = SubscriptionPayment::findOrFail($id);
        $payment->update($validated);

        return redirect()->route('admin.subscription_payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy($id)
    {
        $payment = SubscriptionPayment::findOrFail($id);
        $payment->delete();

        return redirect()->route('admin.subscription_payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}
