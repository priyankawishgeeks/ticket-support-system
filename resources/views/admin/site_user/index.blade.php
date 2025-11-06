@extends('layouts.admin')

@section('page_title', 'Site Users')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h5 class="mb-0">All Site Users</h5>
            <a href="{{ url('admin/site_user/create') }}" class="btn btn-light btn-sm">+ Add New User</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Status</th>
                        <th>Login Type</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                @php
                                    $borderColor = $user->activeSubscription?->plan?->border_color ?? '#ddd'; // fallback gray if no plan
                                @endphp

                                @if($user->photo_url)
                                    <img src="{{ asset($user->photo_url) }}"
                                        title="{{ $user->activeSubscription?->plan?->title ?? 'No active plan' }}" alt="User"
                                        width="40" height="40" class="rounded-circle"
                                        style="border: 3px solid {{ $borderColor }}; padding: 2px;">
                                @else
                                    <div class="rounded-circle d-inline-block"
                                        style="width: 40px; height: 40px; border: 3px solid {{ $borderColor }}; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-user text-muted"></i>
                                    </div>
                                @endif
                            </td>

                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-info">{{ $user->user_type }}</span></td>
                            <td>
                                <form action="{{ url('admin/site_user/status/' . $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button
                                        class="btn btn-sm {{ $user->status == 'Active' ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $user->status }}
                                    </button>
                                </form>
                            </td>
                            <td>{{ $user->login_type }}</td>
                            <td>{{ $user->last_login_at}}</td>
                            <td>
                                <a href="{{ url('admin/site_user/edit/' . $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ url('admin/site_user/delete/' . $user->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection