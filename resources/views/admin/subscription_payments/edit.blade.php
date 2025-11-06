@extends('layouts.admin')

@section('page_title', 'Edit Subscription Payment')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Subscription Payment</h2>

    <form method="POST" action="{{ route('admin.subscription_payments.update', $payment->id) }}">
        @csrf
        @method('PUT')

        <!-- User -->
        <div class="mb-3">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $payment->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->username ?? $user->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Subscription -->
        <div class="mb-3">
            <label>Subscription</label>
            <select name="subscription_id" class="form-control" required>
                @foreach($subscriptions as $subscription)
                    <option value="{{ $subscription->id }}" {{ $payment->subscription_id == $subscription->id ? 'selected' : '' }}>
                        #{{ $subscription->id }} - {{ ucfirst($subscription->status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Plan -->
        <div class="mb-3">
            <label>Plan</label>
            <select name="plan_id" class="form-control" required>
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" {{ $payment->plan_id == $plan->id ? 'selected' : '' }}>
                        {{ $plan->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Amount -->
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount', $payment->amount) }}" class="form-control" required>
        </div>

        <!-- Currency -->
        <div class="mb-3">
            <label>Currency</label>
            <input type="text" name="currency" value="{{ old('currency', $payment->currency ?? 'USD') }}" class="form-control" maxlength="10">
        </div>

        <!-- Payment Method -->
        <div class="mb-3">
            <label>Payment Method</label>
            <input type="text" name="payment_method" class="form-control" value="{{ old('payment_method', $payment->payment_method) }}">
        </div>

        <!-- Payment Reference -->
        <div class="mb-3">
            <label>Payment Reference</label>
            <input type="text" name="payment_reference" class="form-control" value="{{ old('payment_reference', $payment->payment_reference) }}">
        </div>

        <!-- Invoice Number -->
        <div class="mb-3">
            <label>Invoice Number</label>
            <input type="text" name="invoice_number" class="form-control" value="{{ old('invoice_number', $payment->invoice_number) }}">
        </div>

        <!-- Payment Intent ID -->
        <div class="mb-3">
            <label>Payment Intent ID</label>
            <input type="text" name="payment_intent_id" class="form-control" value="{{ old('payment_intent_id', $payment->payment_intent_id) }}">
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                @foreach(['pending', 'processing', 'successful', 'failed', 'refunded', 'cancelled', 'expired'] as $status)
                    <option value="{{ $status }}" {{ $payment->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Payment Type -->
        <div class="mb-3">
            <label>Payment Type</label>
            <select name="payment_type" class="form-control">
                @foreach(['initial', 'renewal', 'upgrade', 'downgrade', 'manual'] as $type)
                    <option value="{{ $type }}" {{ $payment->payment_type === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Renewal Attempt -->
        <div class="mb-3 form-check">
            <input type="checkbox" name="renewal_attempt" value="1" class="form-check-input" id="renewal_attempt"
                   {{ $payment->renewal_attempt ? 'checked' : '' }}>
            <label class="form-check-label" for="renewal_attempt">Renewal Attempt</label>
        </div>

        <!-- Payment Due At -->
        <div class="mb-3">
            <label>Payment Due At</label>
            <input type="date" name="payment_due_at" class="form-control" value="{{ optional($payment->payment_due_at)->format('Y-m-d') }}">
        </div>

        <!-- Paid At -->
        <div class="mb-3">
            <label>Paid At</label>
            <input type="date" name="paid_at" class="form-control" value="{{ optional($payment->paid_at)->format('Y-m-d') }}">
        </div>

        <!-- Refunded At -->
        <div class="mb-3">
            <label>Refunded At</label>
            <input type="date" name="refunded_at" class="form-control" value="{{ optional($payment->refunded_at)->format('Y-m-d') }}">
        </div>

        <!-- Next Retry At -->
        <div class="mb-3">
            <label>Next Retry At</label>
            <input type="date" name="next_retry_at" class="form-control" value="{{ optional($payment->next_retry_at)->format('Y-m-d') }}">
        </div>

        <!-- Retry Count -->
        <div class="mb-3">
            <label>Retry Count</label>
            <input type="number" name="retry_count" class="form-control" value="{{ $payment->retry_count }}" min="0">
        </div>

        <!-- Max Retries -->
        <div class="mb-3">
            <label>Max Retries</label>
            <input type="number" name="max_retries" class="form-control" value="{{ $payment->max_retries }}" min="0">
        </div>

        <!-- Gateway Response -->
        <div class="mb-3">
            <label>Gateway Response (JSON)</label>
            <textarea name="gateway_response" class="form-control" rows="3">{{ old('gateway_response', $payment->gateway_response) }}</textarea>
        </div>

        <!-- Meta -->
        <div class="mb-3">
            <label>Meta (JSON)</label>
            <textarea name="meta" class="form-control" rows="3">{{ old('meta', $payment->meta) }}</textarea>
        </div>

        <!-- Notes -->
        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $payment->notes) }}</textarea>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-success">Update Payment</button>
        <a href="{{ route('admin.subscription_payments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
