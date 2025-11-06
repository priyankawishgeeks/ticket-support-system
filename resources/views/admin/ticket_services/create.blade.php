@extends('layouts.admin')
@section('page_title', 'Add Ticket Service')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Add Ticket Service</h5>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error!</strong> Please fix the issues below.<br><br>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.ticket_services.store') }}" method="POST">
            @csrf

            {{-- Main Category --}}
            <div class="mb-3">
                <label for="main_category_id" class="form-label">Main Category</label>
                <select id="main_category_id" class="form-select" required>
                    <option value="">-- Select Main Category --</option>
                    @foreach($mainCategories as $main)
                        <option value="{{ $main->id }}">{{ $main->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Subcategory --}}
            <div class="mb-3">
                <label for="subcategory_id" class="form-label">Subcategory</label>
                <select name="subcategory_id" id="subcategory_id" class="form-select" required>
                    <option value="">-- Select Subcategory --</option>
                </select>
            </div>

            {{-- Service Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Service Name</label>
                <input type="text" name="name" id="name" class="form-control"
                    placeholder="Enter service name" required>
            </div>

          {{-- Active / Inactive --}}
<input type="hidden" name="is_active" value="0">

<div class="form-check form-switch mb-3">
    <input
        class="form-check-input"
        type="checkbox"
        name="is_active"
        id="is_active"
        value="1"
        {{ old('is_active', 1) ? 'checked' : '' }}
    >
    <label class="form-check-label" for="is_active">Active</label>
</div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('admin.ticket_services.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

{{-- Dependent Dropdown Script --}}
<script>
document.getElementById('main_category_id').addEventListener('change', function () {
    let mainId = this.value;
    let subSelect = document.getElementById('subcategory_id');
    subSelect.innerHTML = '<option value="">Loading...</option>';
    if (!mainId) return;

    fetch(`/admin/ticket_subcategories/${mainId}`)
        .then(res => res.json())
        .then(data => {
            subSelect.innerHTML = '<option value="">-- Select Subcategory --</option>';
            data.forEach(sub => {
                subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
            });
        });
});
</script>
@endsection
