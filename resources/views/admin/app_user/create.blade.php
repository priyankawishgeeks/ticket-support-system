@extends('layouts.admin')
@section('page_title', 'Add New App User')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5>Add New App User</h5>
            </div>

            {{-- ✅ Unified Error / Success Alerts --}}
            @if(session('error') || $errors->any())
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    <strong>Error:</strong>
                    <ul class="mb-0 mt-2">
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
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    <strong>Success:</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('admin.app_user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <select name="title" class="form-control">
                                <option value="">Select Title</option>
                                <option value="Mr" {{ old('title') == 'Mr' ? 'selected' : '' }}>Mr</option>
                                <option value="Mrs" {{ old('title') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                <option value="Ms" {{ old('title') == 'Ms' ? 'selected' : '' }}>Ms</option>
                              
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Username</label>
                            <input type="text" name="user" value="{{ old('user') }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>



                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select name="role_id" class="form-select">
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->role_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Panel</label>
                            <select name="panel" class="form-select" required>
                                <option value="">-- Select Panel --</option>
                                <option value="A" {{ old('panel') == 'A' ? 'selected' : '' }}>Admin</option>
                                <option value="S" {{ old('panel') == 'S' ? 'selected' : '' }}>Staff</option>
                                <option value="U" {{ old('panel') == 'U' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                                class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">-- Select --</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" value="{{ old('country') }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob') }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="img_url" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Region</label>
                            <input type="text" name="region" value="{{ old('region') }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" name="city" value="{{ old('city') }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ZIP</label>
                            <input type="text" name="zip" value="{{ old('zip') }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Enable Chat</label>
                            <select name="is_enable_chat" class="form-select">
                                <option value="1" {{ old('is_enable_chat') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('is_enable_chat') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <a href="{{ route('admin.app_user.index') }}" class="btn btn-secondary">Back</a>
                        <button class="btn btn-success">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .required::after {
        content: " *";
        color: red;
        font-weight: bold;
    }
</style>