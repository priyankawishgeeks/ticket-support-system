@extends('layouts.client')

@section('client_content')
<div class="container mt-5 mb-5 text-center">
    <div class="card mx-auto p-4" style="max-width: 600px;">
        <h3 class="text-success mb-3">✅ Subscription Successful!</h3>
        <p class="mb-4">
            You are now subscribed to <strong>{{ $subscription->plan->title }}</strong>.<br>
            Plan valid till: <strong>{{ $subscription->expires_at->format('d M Y') }}</strong>
        </p>
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
    </div>
</div>
@endsection
