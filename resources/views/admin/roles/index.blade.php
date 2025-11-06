@extends('layouts.admin')

@section('page_title', 'Roles Management')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Roles List</h4>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Add Role</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Role Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->role_name }}</td>
            <td>{{ $role->description }}</td>
            <td>
                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
