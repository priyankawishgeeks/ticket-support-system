@extends('layouts.admin')
@section('page_title', 'All Users')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h4>User List</h4>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Status</th>
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
                        <form action="{{ route('admin.users.status', $user->id) }}" method="POST" class="d-inline">
                            @csrf @method('PUT')
                            <select name="status" class="form-select form-select-sm d-inline-block w-auto"
                                onchange="this.form.submit()">
                                <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $user->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Pending" {{ $user->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection