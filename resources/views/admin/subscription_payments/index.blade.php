@extends('layouts.admin')

@section('page_title')
    Subscription Payments
@endsection

@section('content')
<div class="container">
    <h2 class="mb-3">Subscription Payments</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.subscription_payments.create') }}" class="btn btn-primary">Add New Payment</a>

        <!-- Optional: Import button -->
        <a href="#" class="btn btn-outline-secondary">
            <i class="bi bi-upload"></i> Import
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Plan</th>
                    <th>Subscription</th>
                    <th>Amount</th>
                    <th>Currency</th>
                    <th>Method</th>
                    <th>Invoice</th>
                    <th>Reference</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Paid At</th>
                    <th>Due At</th>
                    <th>Retries</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->user->username ?? $payment->user->email ?? 'N/A' }}</td>
                        <td>{{ $payment->plan->title ?? 'N/A' }}</td>
                        <td>#{{ $payment->subscription->id ?? 'N/A' }}</td>
                        <td>{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->currency }}</td>
                        <td>{{ $payment->payment_method ?? '—' }}</td>
                        <td>{{ $payment->invoice_number ?? '—' }}</td>
                        <td>{{ $payment->payment_reference ?? '—' }}</td>
                        <td>
                            <span class="badge 
                                @if($payment->status === 'successful') bg-success 
                                @elseif($payment->status === 'failed') bg-danger 
                                @elseif($payment->status === 'pending') bg-warning text-dark 
                                @else bg-secondary @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>{{ ucfirst($payment->payment_type) }}</td>
                        <td>{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : '—' }}</td>
                        <td>{{ $payment->payment_due_at ? $payment->payment_due_at->format('Y-m-d') : '—' }}</td>
                        <td>{{ $payment->retry_count }}/{{ $payment->max_retries }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.subscription_payments.edit', $payment) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.subscription_payments.destroy', $payment) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure to delete this payment?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" class="text-center text-muted">No payments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $payments->links() }}
    </div>
</div>
@endsection
