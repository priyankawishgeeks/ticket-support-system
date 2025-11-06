@extends('layouts.admin')
@section('page_title', 'Ticket Services')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Ticket Services</h5>
        <a href="{{ route('admin.ticket_services.create') }}" class="btn btn-primary btn-sm">+ Add Service</a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Service Name</th>
                    <th>Subcategory</th>
                    <th>Main Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->subcategory->name ?? '-' }}</td>
                        <td>{{ $service->subcategory->mainCategory->name ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $service->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.ticket_services.edit', $service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.ticket_services.destroy', $service->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this service?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No services found</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $services->links() }}
    </div>
</div>
@endsection
