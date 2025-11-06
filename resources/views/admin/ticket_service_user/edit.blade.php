@extends('layouts.admin')

@section('page_title', 'Edit Service–User Link')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Edit Service–User Link</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ticket_service_user.update', $link->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="service_id" class="form-label">Select Service</label>
                    <select name="service_id" id="service_id" class="form-select" required>
                        <option value="">-- Select Service --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $link->service_id == $service->id ? 'selected' : '' }}>
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
                            <option value="{{ $user->id }}" {{ $link->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->username }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-warning">Update</button>
                <a href="{{ route('admin.ticket_service_user.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
