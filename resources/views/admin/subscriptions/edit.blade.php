@extends('layouts.admin')
@section('page_title', 'Edit Subscription')

@section('content')
    <div class="card">

        <div class="card-header bg-warning text-white">Edit Subscription</div>

        {{-- ✅ Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ❌ Error Handling (Session + Validation) --}}
        @if(session('error') || $errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <strong>Error:</strong>
                <ul class="mb-0 mt-2">
                    @if(session('error'))
                        <li>{{ session('error') }}</li>
                    @endif
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('admin.subscriptions.update', $subscription->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Site Users --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Site User</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Select User</option>
                            @foreach($site_users as $user)
                                <option value="{{ $user->id }}" {{ $subscription->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->username }} - ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Plan --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Plan</label>
                        <select name="plan_id" id="plan_id" class="form-select" required>
                            <option value="">Select Plan</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}"
                                    data-price="{{ $plan->price }}"
                                    data-currency="{{ $plan->currency ?? 'USD' }}"
                                    data-duration="{{ $plan->duration_days }}"
                                    {{ $subscription->plan_id == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->title }} - {{ $plan->price }} {{ $plan->currency ?? 'USD' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-select" required>
                            @foreach(['active', 'cancelled', 'expired', 'pending', 'trial'] as $status)
                                <option value="{{ $status }}" {{ $subscription->status == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Amount</label>
                        <input type="number" step="0.01" name="amount" id="amount"
                               class="form-control" value="{{ $subscription->amount }}" required>
                    </div>

                    {{-- Currency --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Currency</label>
                        <input type="text" name="currency" id="currency" class="form-control"
                               value="{{ $subscription->currency }}" readonly>
                    </div>

                    {{-- Payment Method --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            @php
                                $paymentMethods = ['Credit Card', 'Debit Card', 'PayPal', 'Stripe', 'Bank Transfer', 'UPI', 'Wallet'];
                            @endphp
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method }}" {{ $subscription->payment_method == $method ? 'selected' : '' }}>
                                    {{ $method }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Payment Reference --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Reference</label>
                        <input type="text" name="payment_reference" class="form-control"
                               value="{{ $subscription->payment_reference }}">
                    </div>

                    {{-- Started At --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Started At</label>
                        <input type="date" name="started_at" id="started_at"
                               class="form-control"
                               value="{{ $subscription->started_at ? $subscription->started_at->format('Y-m-d') : '' }}">
                    </div>

                    {{-- Expires At --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Expires At</label>
                        <input type="date" name="expires_at" id="expires_at"
                               class="form-control"
                               value="{{ $subscription->expires_at ? $subscription->expires_at->format('Y-m-d') : '' }}">
                    </div>

                    {{-- Trial Ends At --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Trial Ends At</label>
                        <input type="date" name="trial_ends_at" class="form-control"
                               value="{{ $subscription->trial_ends_at ? $subscription->trial_ends_at->format('Y-m-d') : '' }}">
                    </div>

                    {{-- Cancelled At --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cancelled At</label>
                        <input type="date" name="cancelled_at" class="form-control"
                               value="{{ $subscription->cancelled_at ? $subscription->cancelled_at->format('Y-m-d') : '' }}">
                    </div>

                    {{-- Renewed At --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Renewed At</label>
                        <input type="date" name="renewed_at" class="form-control"
                               value="{{ $subscription->renewed_at ? $subscription->renewed_at->format('Y-m-d') : '' }}">
                    </div>

                    {{-- Renewal Type --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Renewal Type</label>
                        <select name="renewal_type" class="form-select">
                            <option value="auto" {{ $subscription->renewal_type == 'auto' ? 'selected' : '' }}>Auto</option>
                            <option value="manual" {{ $subscription->renewal_type == 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                    {{-- Notes --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ $subscription->notes }}</textarea>
                    </div>

                    {{-- Meta --}}
                    {{-- <div class="col-md-12 mb-3">
                        <label class="form-label">Meta (JSON)</label>
                        <textarea name="meta" class="form-control" rows="3">{{ json_encode($subscription->meta) }}</textarea>
                    </div> --}}

                </div>

                <div class="text-end">
                    <a href="{{ url('admin/subscriptions') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Update Subscription</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const planSelect = document.getElementById('plan_id');
    const amountInput = document.getElementById('amount');
    const currencyInput = document.getElementById('currency');
    const startedAtInput = document.getElementById('started_at');
    const expiresAtInput = document.getElementById('expires_at');

    // Update amount and currency when plan changes
    planSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const price = selected.getAttribute('data-price');
        const currency = selected.getAttribute('data-currency');
        amountInput.value = price || '';
        currencyInput.value = currency || '';
    });

    // Auto-set expiry date based on plan duration
    function updateExpiry() {
        const selected = planSelect.options[planSelect.selectedIndex];
        const duration = parseInt(selected.getAttribute('data-duration'));
        const startDate = new Date(startedAtInput.value);
        if (!isNaN(duration) && startedAtInput.value) {
            const expiryDate = new Date(startDate);
            expiryDate.setDate(expiryDate.getDate() + duration);
            expiresAtInput.value = expiryDate.toISOString().split('T')[0];
        }
    }

    startedAtInput.addEventListener('change', updateExpiry);
    planSelect.addEventListener('change', updateExpiry);

    if (planSelect.value) planSelect.dispatchEvent(new Event('change'));
});
</script>
@endpush
