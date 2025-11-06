@extends('layouts.client')

@section('client_content')
<div class="container mt-5 mb-5">
    <div class="card mx-auto" style="max-width: 700px;">
        <div class="card-body">
            <h3 class="text-center mb-4">Checkout - {{ $plan->title }}</h3>
            <p class="text-center text-muted mb-4">
                Duration: <strong>{{ $plan->duration_days }} days</strong><br>
                Price: <strong>₹{{ number_format($plan->price, 2) }}</strong>
            </p>

            <form method="POST" action="{{ route('client.checkout.subscribe', $plan->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <select class="form-select" name="payment_method" required>
                        <option value="manual">Manual (Offline)</option>
                        <option value="razorpay">Razorpay (Online)</option>
                        <option value="stripe">Stripe (Card)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Additional Notes</label>
                    <textarea class="form-control" name="notes" rows="3" placeholder="Any instructions?"></textarea>
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold">
                    Confirm & Subscribe
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
