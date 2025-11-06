@extends('layouts.admin')

@section('page_title', 'Add Ticket Main Category')

@section('content')
    <div class="container mt-4">

        <nav class="navbar navbar-light bg-light mb-4 p-3 rounded shadow-sm">
            <div class="container-fluid">
                <h4 class="navbar-brand mb-0">Add Main Category</h4>
                <a href="{{ route('admin.ticket_main_categories.index') }}" class="btn btn-outline-secondary">← Back</a>
            </div>
        </nav>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.ticket_main_categories.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                   <input type="hidden" name="is_active" value="0">

<input type="hidden" name="is_active" value="0">

<div class="form-check form-switch mb-3">
    <input
        class="form-check-input"
        type="checkbox"
        name="is_active"
        id="is_active"
        value="1"
        {{ old('is_active', isset($category) ? (int)$category->is_active : 0) == 1 ? 'checked' : '' }}
    >
    <label class="form-check-label" for="is_active">Active</label>
</div>



                    <button type="submit" class="btn btn-success">Save Category</button>
                    <a href="{{ route('admin.ticket_main_categories.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>

    </div>
@endsection