@extends('layouts.admin')

@section('page_title', 'Expired Subscriptions')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Expired Subscriptions</h2>
        <div>
            <a href="{{ route('admin.expired_subscriptions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Expired Subscription
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Plan</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Expires At</th>
                <th>Expired At</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expiredSubscriptions as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->user->username ?? $item->user->email ?? 'N/A' }}</td>
                    <td>{{ $item->plan_title ?? $item->plan->title ?? 'N/A' }}</td>
                    <td><span class="badge bg-danger">{{ ucfirst($item->status) }}</span></td>
                    <td>{{ $item->amount }} {{ $item->currency }}</td>
                    <td>{{ $item->expires_at ? $item->expires_at->format('Y-m-d') : '—' }}</td>
                    <td>{{ $item->expired_at ? $item->expired_at->format('Y-m-d') : '—' }}</td>
                    <td>{{ Str::limit($item->expiry_reason, 25) }}</td>
                    <td>
                        <a href="{{ route('admin.expired_subscriptions.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.expired_subscriptions.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Are you sure you want to delete this record?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center">No expired subscriptions found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $expiredSubscriptions->links() }}
</div>
@endsection
