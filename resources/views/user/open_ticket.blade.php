@extends('layouts.client')
@section('page_title', 'Open New Ticket')

@section('client_content')
    <div class="container mt-5 mb-5">
        <h4>🎫 Open New Support Ticket</h4>
        <hr>
        @if (session('success'))
            <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <br><small>Redirecting to your ticket details in 3 seconds...</small>
            </div>

            <script>
                setTimeout(() => {
                    window.location.href = "{{ route('user.ticket.showInfo', ['id' => session('ticket_id')]) }}";
                }, 3000);
            </script>
        @endif


        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('user.open_ticket.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">

                {{-- User Info (auto-filled) --}}
                <div class="col-md-6">
                    <label class="form-label">Your Email</label>
                    <input type="email" class="form-control" value="{{ auth('site_user')->user()->email }}" readonly>
                    <input type="hidden" name="ticket_user" value="{{ auth('site_user')->id() }}">

                </div>

                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" value="{{ auth('site_user')->user()->username }}" readonly>
                </div>

                {{-- Category --}}
                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <select name="cat_id" id="cat_id" class="form-select" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
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
                    <input type="url" name="service_url" class="form-control" placeholder="https://example.com"
                        value="{{ old('service_url') }}">
                </div>

                {{-- Title --}}
                <div class="col-md-12">
                    <label class="form-label">Ticket Subject</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter ticket subject" required
                        value="{{ old('title') }}">
                </div>

                {{-- Description --}}
                <div class="col-md-12">
                    <label class="form-label">Ticket Description</label>
                    <textarea name="ticket_body" class="form-control" rows="4" required
                        placeholder="Describe your issue in detail">{{ old('ticket_body') }}</textarea>
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
                        @foreach(['Low', 'Medium', 'High', 'Urgent'] as $p)
                            <option value="{{ $p }}" {{ old('priority', 'Medium') == $p ? 'selected' : '' }}>
                                {{ $p }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary">Submit Ticket</button>
                    <a href="{{ route('user.open_ticket') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection





@push('scripts')

    <script>


        document.addEventListener('DOMContentLoaded', function () {
            const catSelect = document.getElementById('cat_id');
            const subSelect = document.getElementById('subcat_id');
            const serviceSelect = document.getElementById('service_id');
            const baseUrl = "{{ url('client') }}";

            function clearSelect(el, placeholder = 'Select') {
                el.innerHTML = `<option value="">${placeholder}</option>`;
            }

            async function fetchJson(url) {
                try {
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    return res.ok ? await res.json() : [];
                } catch (err) {
                    console.error("Fetch error:", err);
                    return [];
                }
            }

            async function loadSubcategories(catId) {
                clearSelect(subSelect, 'Select Subcategory');
                clearSelect(serviceSelect, 'Select Service');
                if (!catId) return;

                subSelect.innerHTML = `<option>Loading...</option>`;
                const data = await fetchJson(`${baseUrl}/subcategories/${catId}`);
                clearSelect(subSelect, 'Select Subcategory');
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

                serviceSelect.innerHTML = `<option>Loading...</option>`;
                const data = await fetchJson(`${baseUrl}/services/${subId}`);
                clearSelect(serviceSelect, 'Select Service');
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