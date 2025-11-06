@extends('layouts.admin')
@section('page_title', 'Add User')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Add New User</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="Other" selected>Select</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Region</label>
                    <input type="text" name="region" class="form-control" value="{{ old('region') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">ZIP</label>
                    <input type="text" name="zip" class="form-control" value="{{ old('zip') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control" value="{{ old('country') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Timezone</label>
                    <input type="text" name="timezone" class="form-control" value="{{ old('timezone', 'Asia/Kolkata') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Enable Chat?</label>
                    <select name="is_enable_chat" class="form-select">
                        <option value="0" {{ old('is_enable_chat') == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('is_enable_chat') == '1' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Profile Image</label>
                    <input type="file" name="profile_img" class="form-control">
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Save User</button>
            </div>
        </form>
    </div>
</div>
@endsection
