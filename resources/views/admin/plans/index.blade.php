@extends('layouts.admin')
@section('page_title', 'All Plans')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h4>Plans</h4>
        <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">Add New Plan</a>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Price</th>
                <th>Duration (Days)</th>
                <th>Billing Cycle</th>
                <th>Trial Days</th>
                <th>Max Users</th>
                <th>Max Storage (GB)</th>
                <th>Max Projects</th>
                <th>Renewal Type</th>
                <th>Featured</th>
                <th>Badge</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans as $plan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span style="color: {{ $plan->title_color }}">{{ $plan->title }}</span>
                    </td>
                    <td>{{ $plan->slug }}</td>
                    <td>{{ $plan->formatted_price }}</td>
                    <td>{{ $plan->duration_days }}</td>
                    <td>{{ ucfirst($plan->billing_cycle) }}</td>
                    <td>{{ $plan->trial_days }}</td>
                    <td>{{ $plan->max_users ?? '-' }}</td>
                    <td>{{ $plan->max_storage_gb ?? '-' }}</td>
                    <td>{{ $plan->max_projects ?? '-' }}</td>
                    <td>{{ ucfirst($plan->renewal_type) }}</td>
                    <td>
                        @if($plan->is_featured)
                            <span class="badge bg-info">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td>{{ $plan->badge_label ?? '-' }}</td>
                    <td>
                        @if($plan->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this plan?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection