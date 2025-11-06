@extends('layouts.admin')
@section('page_title', 'Create Subscription')

@section('content')
    <div class="card">

        <div class="card-header bg-primary text-white">Add New Subscription</div>

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
            <form action="{{ route('admin.subscriptions.store') }}" method="POST">
                @csrf
                <div class="row">

                    {{-- Site Users --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Site Users</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Select User</option>
                            @foreach($site_users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                                    {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
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
                                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Amount</label>
                        <input type="number" step="" name="amount" id="amount"
                               class="form-control" value="{{ old('amount', 0) }}"
                               readonly required >
                    </div>

                    {{-- Currency --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Currency</label>
                        <input type="text" name="currency" id="currency" class="form-control"
                               value="{{ old('currency', 'USD') }}" readonly >
                    </div>

                    {{-- Payment Method --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            @php
                                $paymentMethods = ['Credit Card', 'Debit Card', 'PayPal', 'Stripe', 'Bank Transfer', 'UPI', 'Wallet'];
                            @endphp
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method }}" {{ old('payment_method') == $method ? 'selected' : '' }}>
                                    {{ $method }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Reference</label>
                        <input type="text" name="payment_reference" class="form-control"
                               value="{{ old('payment_reference') }}">
                    </div>

                    {{-- Started At --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Started At</label>
                        <input type="date" name="started_at" id="started_at"
                               class="form-control" value="{{ old('started_at') }}">
                    </div>

                    {{-- Expires At --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Expires At</label>
                        <input type="date" name="expires_at" id="expires_at"
                               class="form-control" value="{{ old('expires_at') }}">
                    </div>

                    {{-- Trial Ends At --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Trial Ends At</label>
                        <input type="date" name="trial_ends_at" class="form-control"
                               value="{{ old('trial_ends_at') }}">
                    </div>

                    {{-- Cancelled At --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cancelled At</label>
                        <input type="date" name="cancelled_at" class="form-control"
                               value="{{ old('cancelled_at') }}">
                    </div>

                    {{-- Renewed At --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Renewed At</label>
                        <input type="date" name="renewed_at" class="form-control"
                               value="{{ old('renewed_at') }}">
                    </div>

                    {{-- Renewal Type --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Renewal Type</label>
                        <select name="renewal_type" class="form-select">
                            <option value="auto" {{ old('renewal_type') == 'auto' ? 'selected' : '' }}>Auto</option>
                            <option value="manual" {{ old('renewal_type') == 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                    {{-- Notes --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>

                </div>

                <div class="text-end">
                    <a href="{{ url('admin/subscriptions') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Save Subscription</button>
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

    // Update amount and currency on plan change
    planSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const price = selected.getAttribute('data-price');
        const currency = selected.getAttribute('data-currency');

        amountInput.value = price || '';
        currencyInput.value = currency || '';
    });

    // Auto-fill expires_at based on selected plan's duration_days
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

    // Trigger change on load if pre-filled
    if (planSelect.value) planSelect.dispatchEvent(new Event('change'));
});
</script>
@endpush
