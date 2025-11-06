@extends('layouts.admin')

@section('page_title')
    Add Subscription Payment
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Subscription Payment</h2>

    <form method="POST" action="{{ route('admin.subscription_payments.store') }}">
        @csrf

        <!-- User -->
        <div class="mb-3">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->username ?? $user->email }}</option>
                @endforeach
            </select>
        </div>

        <!-- Subscription -->
        <div class="mb-3">
            <label>Subscription</label>
            <select name="subscription_id" class="form-control" required>
                <option value="">Select Subscription</option>
                @foreach($subscriptions as $subscription)
                    <option value="{{ $subscription->id }}">#{{ $subscription->id }} - {{ $subscription->status }}</option>
                @endforeach
            </select>
        </div>

        <!-- Plan -->
        <div class="mb-3">
            <label>Plan</label>
            <select name="plan_id" class="form-control" required>
                <option value="">Select Plan</option>
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}">{{ $plan->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Amount -->
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

        <!-- Currency -->
        <div class="mb-3">
            <label>Currency</label>
            <input type="text" name="currency" class="form-control" value="USD" maxlength="10" required>
        </div>

        <!-- Payment Method -->
        <div class="mb-3">
            <label>Payment Method</label>
            <input type="text" name="payment_method" class="form-control" placeholder="e.g. Stripe, PayPal, Razorpay">
        </div>

        <!-- Payment Reference -->
        <div class="mb-3">
            <label>Payment Reference</label>
            <input type="text" name="payment_reference" class="form-control" placeholder="e.g. TXN12345">
        </div>

        <!-- Invoice Number -->
        <div class="mb-3">
            <label>Invoice Number</label>
            <input type="text" name="invoice_number" class="form-control" placeholder="e.g. INV-00123">
        </div>

        <!-- Payment Intent ID -->
        <div class="mb-3">
            <label>Payment Intent ID</label>
            <input type="text" name="payment_intent_id" class="form-control" placeholder="e.g. pi_abc123">
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option>pending</option>
                <option>processing</option>
                <option>successful</option>
                <option>failed</option>
                <option>refunded</option>
                <option>cancelled</option>
                <option>expired</option>
            </select>
        </div>

        <!-- Payment Type -->
        <div class="mb-3">
            <label>Payment Type</label>
            <select name="payment_type" class="form-control">
                <option>initial</option>
                <option>renewal</option>
                <option>upgrade</option>
                <option>downgrade</option>
                <option>manual</option>
            </select>
        </div>

        <!-- Renewal Attempt -->
        <div class="mb-3 form-check">
            <input type="checkbox" name="renewal_attempt" value="1" class="form-check-input" id="renewal_attempt">
            <label class="form-check-label" for="renewal_attempt">Renewal Attempt</label>
        </div>

        <!-- Payment Due At -->
        <div class="mb-3">
            <label>Payment Due At</label>
            <input type="date" name="payment_due_at" class="form-control">
        </div>

        <!-- Paid At -->
        <div class="mb-3">
            <label>Paid At</label>
            <input type="date" name="paid_at" class="form-control">
        </div>

        <!-- Refunded At -->
        <div class="mb-3">
            <label>Refunded At</label>
            <input type="date" name="refunded_at" class="form-control">
        </div>

        <!-- Next Retry At -->
        <div class="mb-3">
            <label>Next Retry At</label>
            <input type="date" name="next_retry_at" class="form-control">
        </div>

        <!-- Retry Count -->
        <div class="mb-3">
            <label>Retry Count</label>
            <input type="number" name="retry_count" class="form-control" value="0" min="0">
        </div>

        <!-- Max Retries -->
        <div class="mb-3">
            <label>Max Retries</label>
            <input type="number" name="max_retries" class="form-control" value="3" min="0">
        </div>

        <!-- Gateway Response -->
        <div class="mb-3">
            <label>Gateway Response (JSON)</label>
            <textarea name="gateway_response" class="form-control" rows="3" placeholder='{"transaction_id": "123"}'></textarea>
        </div>

        <!-- Meta -->
        <div class="mb-3">
            <label>Meta (JSON)</label>
            <textarea name="meta" class="form-control" rows="3" placeholder='{"note": "optional info"}'></textarea>
        </div>

        <!-- Notes -->
        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="Additional remarks..."></textarea>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-success">Save Payment</button>
        <a href="{{ route('admin.subscription_payments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
