@extends('layouts.admin')

@section('page_title', 'Service–User Links')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Service–User Links</h3>
        <a href="{{ route('admin.ticket_service_user.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Add New Link
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Service</th>
                        <th>User</th>
                        <th>Created At</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($links as $link)
                        <tr>
                            <td>{{ $link->id }}</td>
                            <td>{{ $link->service->name ?? '—' }}</td>
                            <td>{{ $link->SiteUser->username ?? '—' }}</td>
                            <td>{{ $link->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.ticket_service_user.edit', $link->id) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                <form action="{{ route('admin.ticket_service_user.destroy', $link->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this link?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No service-user links found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
