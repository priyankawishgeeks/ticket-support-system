@extends('layouts.admin')
@section('page_title', 'Ticket Subcategories')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Ticket Subcategories</h4>
        <a href="{{ route('admin.ticket_subcategories.create') }}" class="btn btn-primary">+ Add New</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Subcategory Name</th>
                        <th>Main Category</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subcategories as $subcategory)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subcategory->name }}</td>
                            <td>{{ $subcategory->mainCategory->name ?? 'N/A' }}</td>
                            <td>
                                @if($subcategory->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $subcategory->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.ticket_subcategories.edit', $subcategory->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.ticket_subcategories.destroy', $subcategory->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this subcategory?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">No subcategories found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $subcategories->links() }}
    </div>
</div>
@endsection
