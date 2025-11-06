@extends('layouts.admin')
@section('page_title', 'Add Canned Message')

@section('content')
<div class="container mt-4">
    <h4>➕ Add New Canned Message</h4>
    <hr>

    <form action="{{ route('admin.canned_messages.store') }}" method="POST">
        @csrf

        <div class="card shadow-sm p-4">
            <div class="row g-3">
                {{-- Title --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                {{-- Subject --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">Subject</label>
                    <input type="text" name="subject" class="form-control">
                </div>

                {{-- Type --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">Type</label>
                    <select name="type" class="form-select" required>
                        <option value="text">Text</option>
                        <option value="html">HTML</option>
                        <option value="markdown">Markdown</option>
                    </select>
                </div>

                {{-- Category --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">Category</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Subcategory --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">Subcategory</label>
                    <select name="subcategory_id" id="subcategory_id" class="form-select">
                        <option value="">Select Subcategory</option>
                    </select>
                </div>

                {{-- Service --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">Service</label>
                    <select name="service_id" id="service_id" class="form-select">
                        <option value="">Select Service</option>
                    </select>
                </div>

                {{-- Body --}}
                <div class="col-12">
                    <label class="form-label fw-bold">Body</label>
                    <textarea name="body" rows="5" class="form-control" required></textarea>
                </div>

                {{-- Is Global --}}
                <div class="col-md-4 form-check mt-3">
                    <input type="checkbox" name="is_global" id="is_global" class="form-check-input">
                    <label for="is_global" class="form-check-label fw-bold">Make Global</label>
                </div>

                {{-- Status --}}
                <div class="col-md-4 mt-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <a href="{{ route('admin.canned_messages.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const catSelect = document.getElementById('category_id');
    const subSelect = document.getElementById('subcategory_id');
    const serviceSelect = document.getElementById('service_id');

    function clearSelect(select, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
    }

    async function fetchOptions(url) {
        try {
            const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
            return response.ok ? await response.json() : [];
        } catch {
            return [];
        }
    }

    async function loadSubcategories(categoryId) {
        clearSelect(subSelect, 'Select Subcategory');
        clearSelect(serviceSelect, 'Select Service');
        if (!categoryId) return;
        const subs = await fetchOptions(`/admin/subcategories/${categoryId}`);
        subs.forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub.id;
            opt.textContent = sub.name;
            subSelect.appendChild(opt);
        });
    }

    async function loadServices(subcategoryId) {
        clearSelect(serviceSelect, 'Select Service');
        if (!subcategoryId) return;
        const services = await fetchOptions(`/admin/services/${subcategoryId}`);
        services.forEach(srv => {
            const opt = document.createElement('option');
            opt.value = srv.id;
            opt.textContent = srv.name;
            serviceSelect.appendChild(opt);
        });
    }

    catSelect.addEventListener('change', () => loadSubcategories(catSelect.value));
    subSelect.addEventListener('change', () => loadServices(subSelect.value));
});
</script>
@endpush
