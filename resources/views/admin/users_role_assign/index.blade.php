@extends('layouts.admin')
@section('page_title', 'User Role Assignments')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>User Role Management</h4>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
            <th>Assigned Roles</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->roles->count())
                    @foreach($user->roles as $role)
                        <span class="badge bg-info text-dark me-1">{{ $role->role_name }}</span>
                        <form action="{{ route('admin.user_roles.destroy', [$user->id, $role->id]) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger btn-sm py-0"
                                onclick="return confirm('Remove this role?')">x</button>
                        </form>
                    @endforeach
                @else
                    <span class="text-muted">No Roles</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.user_roles.edit', $user->id) }}" class="btn btn-sm btn-warning">Assign/Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
