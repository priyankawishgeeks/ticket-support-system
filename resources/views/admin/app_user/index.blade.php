@extends('layouts.admin')
@section('page_title', 'Manage App Users')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>App Users</h4>
        <a href="{{ route('admin.app_user.create') }}" class="btn btn-primary">+ Add New User</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Panel</th>
                        <th>Status</th>
                        {{-- <th>Contact</th> --}}
                        {{-- <th>Gender</th> --}}
                        {{-- <th>Country</th> --}}
                        {{-- <th>Enable Chat</th> --}}
                        {{-- <th>Join Date</th> --}}
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->user }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->role_name ?? '-' }}</td>
                        <td>{{ $user->panel }}</td>
                        <td>
                            <span class="badge bg-{{ $user->status == 'Active' ? 'success' : 'secondary' }}">
                                {{ $user->status }}
                            </span>
                        </td>
                        {{-- <td>{{ $user->contact_number }}</td> --}}
                        {{-- <td>{{ $user->gender }}</td> --}}
                        {{-- <td>{{ $user->country }}</td> --}}
                        {{-- <td>{{ $user->is_enable_chat ? 'Yes' : 'No' }}</td> --}}
                        {{-- <td>{{ $user->add_date }}</td> --}}
                        <td>
                            <a href="{{ route('admin.app_user.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            {{-- <form action="{{ route('admin.app_user.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                            </form> --}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
