@extends('layouts.admin')
@section('page_title', 'Create Subcategory')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add New Ticket Subcategory</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ticket_subcategories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="main_category_id" class="form-label">Main Category</label>
                    <select name="main_category_id" id="main_category_id" class="form-select" required>
                        <option value="">-- Select Main Category --</option>
                        @foreach($mainCategories as $category)
                            <option value="{{ $category->id }}" {{ old('main_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('main_category_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Subcategory Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

           <input type="hidden" name="is_active" value="0">

<div class="form-check form-switch mb-3">
    <input
        class="form-check-input"
        type="checkbox"
        name="is_active"
        id="is_active"
        value="1"
        {{ old('is_active', isset($subcategory) ? $subcategory->is_active : 1) ? 'checked' : '' }}
    >
    <label class="form-check-label" for="is_active">Active</label>
</div>

                <div class="text-end">
                    <a href="{{ route('admin.ticket_subcategories.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Save Subcategory</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
