@extends('layouts.admin')
@section('page_title', 'Create Ticket')

@section('content')
<div class="container mt-4">
    <h4>➕ Create New Ticket</h4>
    <hr>

    <form action="{{ route('admin.tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">

            {{-- User Email --}}
            <div class="col-md-4">
                <label class="form-label">User Email</label>
                <select name="ticket_user" id="ticket_user" class="form-select" required>
                    <option value="">Select User</option>
                    @foreach($siteUsers as $user)
                        <option value="{{ $user->id }}" {{ old('ticket_user') == $user->id ? 'selected' : '' }}>
                            {{ $user->email }} ({{ $user->username }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Category --}}
            <div class="col-md-4">
                <label class="form-label">Category</label>
                <select name="cat_id" id="cat_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('cat_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Subcategory --}}
            <div class="col-md-4">
                <label class="form-label">Subcategory</label>
                <select name="services_cat_id" id="subcat_id" class="form-select">
                    <option value="">Select Subcategory</option>
                </select>
            </div>

            {{-- Service --}}
            <div class="col-md-4">
                <label class="form-label">Service</label>
                <select name="services" id="service_id" class="form-select">
                    <option value="">Select Service</option>
                </select>
            </div>

            {{-- Service URL --}}
            <div class="col-md-8">
                <label class="form-label">Service URL</label>
                <input type="url" name="service_url" class="form-control"
                       value="{{ old('service_url') }}" placeholder="https://example.com">
            </div>

            {{-- Title --}}
            <div class="col-md-12">
                <label class="form-label">Ticket Subject</label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title') }}" required>
            </div>

            {{-- Description --}}
            <div class="col-md-12">
                <label class="form-label">Ticket Body</label>
                <textarea name="ticket_body" class="form-control" rows="4" required>{{ old('ticket_body') }}</textarea>
            </div>

            {{-- Attachments --}}
            <div class="col-md-12">
                <label class="form-label">Attachments (optional)</label>
                <input type="file" name="attachments[]" class="form-control" multiple>
            </div>

            {{-- Priority --}}
            <div class="col-md-6">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-select" required>
                    @foreach(['Low','Medium','High','Urgent'] as $p)
                        <option value="{{ $p }}" {{ old('priority', 'Medium') == $p ? 'selected' : '' }}>
                            {{ $p }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Buttons --}}
            <div class="col-12 text-end mt-3">
                <button type="submit" class="btn btn-primary">Create Ticket</button>
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const catSelect = document.getElementById('cat_id');
    const subSelect = document.getElementById('subcat_id');
    const serviceSelect = document.getElementById('service_id');

    function clearSelect(el, placeholder = 'Select') {
        el.innerHTML = `<option value="">${placeholder}</option>`;
    }

    async function fetchJson(url) {
        try {
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            return res.ok ? await res.json() : [];
        } catch {
            return [];
        }
    }

    async function loadSubcategories(catId) {
        clearSelect(subSelect, 'Select Subcategory');
        clearSelect(serviceSelect, 'Select Service');
        if (!catId) return;

        const data = await fetchJson(`/admin/subcategories/${catId}`);
        data.forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub.id;
            opt.textContent = sub.name;
            subSelect.appendChild(opt);
        });
    }

    async function loadServices(subId) {
        clearSelect(serviceSelect, 'Select Service');
        if (!subId) return;

        const data = await fetchJson(`/admin/services/${subId}`);
        data.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.id;
            opt.textContent = s.name;
            serviceSelect.appendChild(opt);
        });
    }

    catSelect.addEventListener('change', () => loadSubcategories(catSelect.value));
    subSelect.addEventListener('change', () => loadServices(subSelect.value));
});
</script>
@endpush
