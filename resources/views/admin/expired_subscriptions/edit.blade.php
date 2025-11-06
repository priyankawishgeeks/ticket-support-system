@extends('layouts.admin')

@section('page_title', 'Edit Expired Subscription')

@section('content')
<div class="container">
    <h2>Edit Expired Subscription #{{ $expiredSubscription->id }}</h2>

    <form action="{{ route('admin.expired_subscriptions.update', $expiredSubscription->id) }}" method="POST" class="card p-4">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>User</label>
                <select name="user_id" class="form-select" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $expiredSubscription->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->username ?? $user->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Plan</label>
                <select name="plan_id" class="form-select">
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ $expiredSubscription->plan_id == $plan->id ? 'selected' : '' }}>
                            {{ $plan->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" 
                    value="{{ $expiredSubscription->amount }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Currency</label>
                <input type="text" name="currency" class="form-control" value="{{ $expiredSubscription->currency }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    @foreach(['expired','cancelled','grace_period','renewal_failed','archived'] as $status)
                        <option value="{{ $status }}" {{ $expiredSubscription->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Renewal Type</label>
                <select name="renewal_type" class="form-select">
                    <option value="auto" {{ $expiredSubscription->renewal_type == 'auto' ? 'selected' : '' }}>Auto</option>
                    <option value="manual" {{ $expiredSubscription->renewal_type == 'manual' ? 'selected' : '' }}>Manual</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Expiry Reason</label>
                <textarea name="expiry_reason" class="form-control" rows="2">{{ $expiredSubscription->expiry_reason }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>Admin Notes</label>
                <textarea name="admin_notes" class="form-control" rows="2">{{ $expiredSubscription->admin_notes }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>Expired At</label>
                <input type="datetime-local" name="expired_at" class="form-control" 
                    value="{{ $expiredSubscription->expired_at ? $expiredSubscription->expired_at->format('Y-m-d\TH:i') : '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Expires At</label>
                <input type="datetime-local" name="expires_at" class="form-control"
                    value="{{ $expiredSubscription->expires_at ? $expiredSubscription->expires_at->format('Y-m-d\TH:i') : '' }}">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.expired_subscriptions.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Update Record</button>
        </div>
    </form>
</div>
@endsection
