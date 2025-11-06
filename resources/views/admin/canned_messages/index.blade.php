@extends('layouts.admin')
@section('page_title', 'Canned Messages')

@section('content')
<div class="container mt-4">
  
    <div class="d-flex justify-content-between mb-3">
          <h4>💬 Canned Messages</h4>
        <a href="{{ route('admin.canned_messages.create') }}" class="btn btn-primary">➕ Add New</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Service</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Global</th>
                        <th>Created At</th>
                        <th class="text-center" width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cannedMessages as $msg)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $msg->title }}</td>
                            <td>{{ $msg->subject ?? '-' }}</td>
                            <td>{{ $msg->category->name ?? '-' }}</td>
                            <td>{{ $msg->subcategory->name ?? '-' }}</td>
                            <td>{{ $msg->service->name ?? '-' }}</td>
                            <td><span class="badge bg-info">{{ ucfirst($msg->type) }}</span></td>
                            <td>
                                <span class="badge {{ $msg->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($msg->status) }}
                                </span>
                            </td>
                            <td>{{ $msg->createdBy->user ?? 'N/A' }}</td>
                            <td>{!! $msg->is_global ? '<span class="badge bg-primary">Yes</span>' : 'No' !!}</td>
                            <td>{{ $msg->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.canned_messages.edit', $msg->id) }}" class="btn btn-sm btn-warning">✏️</a>
                                <form action="{{ route('admin.canned_messages.delete', $msg->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this message?')">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="12" class="text-center text-muted">No canned messages found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $cannedMessages->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
