@extends('layouts.admin')

@section('page_title', 'Assign Service to User')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Assign Service to User</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ticket_service_user.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="service_id" class="form-label">Select Service</label>
                    <select name="service_id" id="service_id" class="form-select" required>
                        <option value="">-- Select Service --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="user_id" class="form-label">Select User</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">-- Select User --</option>
                        @foreach($siteUsers as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->username }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('admin.ticket_service_user.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
