@extends('layouts.admin')

@section('page_title', 'Edit Site User')

@section('content')
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Edit Site User - {{ $user->first_name }} {{ $user->last_name }}</h5>
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong> Please check form fields.
                    <ul>
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('admin/site_user/update/' . $user->id) }}" enctype="multipart/form-data">
                @csrf

                @method('PUT')


                <div class="row">
                    <!-- Basic Info -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">First Name</label>
                        <input type="text" name="first_name" class="form-control"
                            value="{{ old('first_name', $user->first_name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control"
                            value="{{ old('last_name', $user->last_name) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Username</label>
                        <input type="text" name="username" class="form-control"
                            value="{{ old('username', $user->username) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control">
                        <small class="text-muted">Leave blank to keep current password.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob"
                            value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}"
                            class="form-control">
                    </div>


                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select</option>
                            @foreach(['Male', 'Female', 'Other'] as $g)
                                <option value="{{ $g }}" {{ old('gender', $user->gender) == $g ? 'selected' : '' }}>{{ $g }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ old('country', $user->country) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Region</label>
                        <input type="text" name="region" class="form-control" value="{{ old('region', $user->region) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ZIP</label>
                        <input type="text" name="zip" class="form-control" value="{{ old('zip', $user->zip) }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control"
                            rows="2">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <!-- Account Info -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-select" required>
                            @foreach(['Active', 'Inactive', 'Locked', 'Suspended'] as $s)
                                <option value="{{ $s }}" {{ old('status', $user->status) == $s ? 'selected' : '' }}>{{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">User Type</label>
                        <select name="user_type" class="form-select" required>
                            @foreach(['User', 'Admin', 'Guest'] as $t)
                                <option value="{{ $t }}" {{ old('user_type', $user->user_type) == $t ? 'selected' : '' }}>{{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Photo -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo_url" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif">
                        @if($user->photo_url)
                            <img src="{{ asset($user->photo_url) }}" width="60" class="mt-2 rounded border">
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url('admin/site_user') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-warning text-white">Update User</button>
                </div>
            </form>
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