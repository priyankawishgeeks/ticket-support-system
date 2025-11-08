@extends('layouts.admin')
@section('page_title', 'Add New App User')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold text-dark">Add New App User</h5>
            <a href="{{ route('admin.app_user.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        {{-- ✅ Unified Alerts --}}
        <div class="p-3">
            @if(session('error') || $errors->any())
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    <strong>Error:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        @if(session('error'))
                            <li>{{ session('error') }}</li>
                        @endif
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                    <strong>Success:</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <div class="card-body">
            <form action="{{ route('admin.app_user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <!-- Title -->
                    <div class="col-md-6">
                        <label class="form-label">Title</label>
                        <select name="title" class="form-select">
                            <option value="">Select Title</option>
                            <option value="Mr" {{ old('title') == 'Mr' ? 'selected' : '' }}>Mr</option>
                            <option value="Mrs" {{ old('title') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                            <option value="Ms" {{ old('title') == 'Ms' ? 'selected' : '' }}>Ms</option>
                        </select>
                    </div>

                    <!-- Username -->
                    <div class="col-md-6">
                        <label class="form-label required">Username</label>
                        <input type="text" name="user" value="{{ old('user') }}" class="form-control form-control-sm" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-sm" required>
                    </div>

                    <!-- Password -->
                    <div class="col-md-6">
                        <label class="form-label required">Password</label>
                        <input type="password" name="password" class="form-control form-control-sm" required>
                    </div>

                    <!-- Role -->
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role_id" class="form-select form-select-sm">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->role_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Panel -->
                    <div class="col-md-6">
                        <label class="form-label required">Panel</label>
                        <select name="panel" class="form-select form-select-sm" required>
                            <option value="">-- Select Panel --</option>
                            <option value="A" {{ old('panel') == 'A' ? 'selected' : '' }}>Admin</option>
                            <option value="S" {{ old('panel') == 'S' ? 'selected' : '' }}>Staff</option>
                            <option value="U" {{ old('panel') == 'U' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-select form-select-sm" required>
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Contact Number -->
                    <div class="col-md-6">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number') }}" class="form-control form-control-sm">
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select form-select-sm">
                            <option value="">-- Select --</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Country -->
                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" value="{{ old('country') }}" class="form-control form-control-sm">
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob') }}" class="form-control form-control-sm">
                    </div>

                    <!-- Profile Image -->
                    <div class="col-md-6">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="img_url" class="form-control form-control-sm" accept=".jpg,.jpeg,.png,.webp,.gif">
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="form-control form-control-sm">
                    </div>

                    <!-- Region -->
                    <div class="col-md-6">
                        <label class="form-label">Region</label>
                        <input type="text" name="region" value="{{ old('region') }}" class="form-control form-control-sm">
                    </div>

                    <!-- City -->
                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" name="city" value="{{ old('city') }}" class="form-control form-control-sm">
                    </div>

                    <!-- ZIP -->
                    <div class="col-md-6">
                        <label class="form-label">ZIP</label>
                        <input type="text" name="zip" value="{{ old('zip') }}" class="form-control form-control-sm">
                    </div>

                    <!-- Enable Chat -->
                    <div class="col-md-6">
                        <label class="form-label">Enable Chat</label>
                        <select name="is_enable_chat" class="form-select form-select-sm">
                            <option value="1" {{ old('is_enable_chat') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_enable_chat') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-success px-4">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .required::after {
        content: " *";
        color: #dc2626;
        font-weight: bold;
    }

    .card-header {
        padding: 1rem 1.25rem;
    }

    .form-label {
        font-weight: 500;
        color: #374151;
    }

    .form-control,
    .form-select {
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.15rem rgba(37, 99, 235, 0.1);
    }

    .btn-success {
        background-color: #16a34a;
        border-color: #16a34a;
        font-weight: 500;
        border-radius: 6px;
    }

    .btn-success:hover {
        background-color: #15803d;
        border-color: #15803d;
    }

    .btn-light {
        color: #374151;
        border-color: #e5e7eb;
    }

    .btn-light:hover {
        background-color: #f3f4f6;
    }

    .alert ul {
        margin-bottom: 0;
    }
</style>
@endpush
