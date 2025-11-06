@extends('layouts.admin')

@section('page_title', 'Add Site User')

@section('content')
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Add New Site User</h5>
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

            <form method="POST" action="{{ url('admin/site_user/store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">First Name </label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label ">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Username </label>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Email </label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required ">Password </label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label ">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Status </label>
                        <select name="status" class="form-select" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Locked">Locked</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">User Type </label>
                        <select name="user_type" class="form-select" required>
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                            <option value="Guest">Guest</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label ">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label ">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ old('country') }}">
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


                    <div class="col-md-12 mb-3">
                        <label class="form-label ">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label ">Photo</label>
                        <input type="file" name="photo_url" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif">
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url('admin/site_user') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Save User</button>
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