@extends('layouts.admin')
@section('page_title', 'Assign Roles')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Assign Roles to: {{ $user->username }}</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.user_roles.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Select Roles</label>
                <select name="roles[]" class="form-select" multiple required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple roles.</small>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Save Roles</button>
                <a href="{{ route('admin.user_roles.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
