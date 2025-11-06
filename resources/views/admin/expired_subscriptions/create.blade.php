@extends('layouts.admin')

@section('page_title', 'Add Expired Subscription')

@section('content')
<div class="container">
    <h2>Add Expired Subscription</h2>

    <form action="{{ route('admin.expired_subscriptions.store') }}" method="POST" class="card p-4">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>User</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Select User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->username ?? $user->email }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Plan</label>
                <select name="plan_id" class="form-select">
                    <option value="">-- Select Plan --</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}">{{ $plan->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="0.00">
            </div>

            <div class="col-md-4 mb-3">
                <label>Currency</label>
                <input type="text" name="currency" class="form-control" value="USD">
            </div>

            <div class="col-md-4 mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="expired">Expired</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="grace_period">Grace Period</option>
                    <option value="renewal_failed">Renewal Failed</option>
                    <option value="archived">Archived</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Renewal Type</label>
                <select name="renewal_type" class="form-select">
                    <option value="auto">Auto</option>
                    <option value="manual">Manual</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Expiry Reason</label>
                <textarea name="expiry_reason" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>Admin Notes</label>
                <textarea name="admin_notes" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>Expired At</label>
                <input type="datetime-local" name="expired_at" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Expires At</label>
                <input type="datetime-local" name="expires_at" class="form-control">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.expired_subscriptions.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Save Record</button>
        </div>
    </form>
</div>
@endsection
