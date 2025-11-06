@extends('layouts.admin')
@section('page_title', 'Edit Subcategory')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            <h5 class="mb-0 text-dark">Edit Ticket Subcategory</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ticket_subcategories.update', $subcategory->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="main_category_id" class="form-label">Main Category</label>
                    <select name="main_category_id" id="main_category_id" class="form-select" required>
                        <option value="">-- Select Main Category --</option>
                        @foreach($mainCategories as $category)
                            <option value="{{ $category->id }}" {{ $subcategory->main_category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('main_category_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Subcategory Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $subcategory->name) }}" required>
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
                    <button type="submit" class="btn btn-primary">Update Subcategory</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
