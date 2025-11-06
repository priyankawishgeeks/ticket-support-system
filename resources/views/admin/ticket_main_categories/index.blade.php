@extends('layouts.admin')

@section('page_title', 'Ticket Main Categories')

@section('content')
<div class="container mt-4">

    <nav class="navbar navbar-light bg-light mb-4 p-3 rounded shadow-sm">
        <div class="container-fluid">
            <h4 class="navbar-brand mb-0">Ticket Main Categories</h4>
            <div>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">← Back</a>
                <a href="{{ route('admin.ticket_main_categories.create') }}" class="btn btn-primary">
                    + Add New Category
                </a>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Created At</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        @if($category->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $category->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.ticket_main_categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
                            Edit
                        </a>
                        <form action="{{ route('admin.ticket_main_categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this category?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
