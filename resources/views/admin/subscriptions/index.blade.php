@extends('layouts.admin')
@section('page_title', 'Subscriptions')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Subscriptions</h4>
    <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">Add New Subscription</a>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Plan</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Started At</th>
            <th>Expires At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subscriptions as $subscription)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $subscription->siteUser->username }}</td>
            <td>{{ $subscription->plan->title }}</td>
            <td>{{ ucfirst($subscription->status) }}</td>
            <td>{{ $subscription->currency }} {{ $subscription->amount }}</td>
            <td>{{ $subscription->started_at?->format('Y-m-d H:i') }}</td>
            <td>{{ $subscription->expires_at?->format('Y-m-d H:i') }}</td>
            <td>
                <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.subscriptions.destroy', $subscription->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this subscription?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
