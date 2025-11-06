@extends('layouts.admin')
@section('page_title', 'All Active Tickets')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>🎫 All Active Tickets</h4>
            <div>
                <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">+ Create Ticket</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Track ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Open Time</th>
                            <th>Ticket User</th>
                            <th>Assigned</th>
                            <th>Replies</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Last Reply</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td><span class="badge bg-info">{{ $ticket->ticket_track_id }}</span></td>

                                <td class="text-start">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                        class="fw-semibold text-decoration-none">
                                        {{ Str::limit($ticket->title, 40) }}
                                    </a>
                                </td>

                                <td>{{ $ticket->category->name ?? '-' }}</td>
                                <td><span class="text-muted"
                                        title="{{ $ticket->opened_time }}">{{ $ticket->opened_time  }}</span></td>

                                {{-- Ticket User --}}
                                <td class="text-start">
                                    @php
                                        $borderColor = $ticket->siteUser?->activeSubscription?->plan?->border_color ?? '#ddd';
                                        $profileImg = $ticket->siteUser?->profile_img
                                            ? asset('storage/' . $ticket->siteUser->profile_img)
                                            : null;
                                        $username = $ticket->siteUser?->username ?? 'N/A';
                                        $initial = strtoupper(substr($username, 0, 1));
                                        $planTitle = $ticket->siteUser?->activeSubscription?->plan?->title ?? 'No active plan';
                                    @endphp

                                    @if($profileImg)
                                        <img src="{{ $profileImg }}" alt="avatar" title="{{ $planTitle }}" width="40" height="40"
                                            class="rounded-circle me-2" style="border: 3px solid {{ $borderColor }}; padding: 2px;">
                                    @else
                                        <span title="{{ $planTitle }}"
                                            class="me-2 rounded-circle d-inline-flex justify-content-center align-items-center text-white"
                                            style="width:40px; height:40px; border:3px solid {{ $borderColor }}; background:#6c757d;">
                                            {{ $initial }}
                                        </span>
                                    @endif

                                    {{ $username }}
                                </td>


                                {{-- Assigned User --}}
                                {{-- <td>{{ $ticket->assignee->user ?? '-' }}</td> --}}

                                <td class="align-middle">
                                    @if(is_null($ticket->assigned_to))
                                        {{-- If not assigned, show "Set Assign" button --}}
                                        <a href="{{ route('admin.tickets.set_assign', $ticket->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bi bi-person-plus-fill"></i> Set Assign
                                        </a>
                                    @else
                                        {{-- If assigned, show assigned user details --}}
                                        @php
                                            $user = $ticket->assignee; // assuming relation Ticket->assignee()
                                            $role = \App\Models\Role::find($user->role_id);
                                        @endphp

                                        <div class="d-flex align-items-center gap-2">
                                            {{-- User image --}}
                                            @if(!empty($user->img_url))
                                                <img src="{{ asset($user->img_url) }}" alt="{{ $user->user }}" class="rounded-circle"
                                                    width="40" height="40">
                                            @else
                                                <img src="{{ asset('images/default-user.png') }}" alt="User" class="rounded-circle"
                                                    width="40" height="40">
                                            @endif

                                            {{-- User details --}}
                                            <div>
                                                <div class="fw-bold">{{ $user->user ?? 'User #' . $user->id }}</div>
                                                <div class="text-muted small">{{ $user->panel ?? 'App User' }}</div>
                                                <div class="badge bg-secondary">{{ $role->role_name ?? 'No Role' }}</div>
                                            </div>
                                        </div>
                                    @endif
                                </td>




                                <td><span class="badge bg-light text-dark">{{ $ticket->reply_counter }}</span></td>

                                {{-- Status --}}
                                <!-- Ticket Status -->
                                <td>
                                    <select class="form-select form-select-sm ticket-status" data-id="{{ $ticket->id }}">
                                        <option value="New" {{ $ticket->status === 'New' ? 'selected' : '' }}>New</option>
                                        <option value="Open" {{ $ticket->status === 'Open' ? 'selected' : '' }}>Open</option>
                                        <option value="In Progress" {{ $ticket->status === 'In Progress' ? 'selected' : '' }}>In
                                            Progress</option>
                                        <option value="On Hold" {{ $ticket->status === 'On Hold' ? 'selected' : '' }}>On Hold
                                        </option>
                                        <option value="Waiting for Customer" {{ $ticket->status === 'Waiting for Customer' ? 'selected' : '' }}>Waiting for Customer</option>
                                        <option value="Resolved" {{ $ticket->status === 'Resolved' ? 'selected' : '' }}>Resolved
                                        </option>
                                        <option value="Closed" {{ $ticket->status === 'Closed' ? 'selected' : '' }}>Closed
                                        </option>
                                        <option value="Reopened" {{ $ticket->status === 'Reopened' ? 'selected' : '' }}>Reopened
                                        </option>
                                    </select>
                                </td>


                                <td>
                                    <select class="form-select form-select-sm ticket-priority" data-id="{{ $ticket->id }}">
                                        <option value="Low" {{ $ticket->priority === 'Low' ? 'selected' : '' }}>Low</option>
                                        <option value="Medium" {{ $ticket->priority === 'Medium' ? 'selected' : '' }}>Medium
                                        </option>
                                        <option value="High" {{ $ticket->priority === 'High' ? 'selected' : '' }}>High</option>
                                        <option value="Urgent" {{ $ticket->priority === 'Urgent' ? 'selected' : '' }}>Urgent
                                        </option>
                                        <option value="Critical" {{ $ticket->priority === 'Critical' ? 'selected' : '' }}>Critical
                                        </option>
                                    </select>
                                </td>


                                {{-- Last Reply --}}
                                <td><span class="text-muted"
                                        title="{{ $ticket->last_reply_time }}">{{ $ticket->last_reply_time  }}</span></td>

                                {{-- Actions --}}
                                <td class="text-end">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-info"><i
                                            class="fa fa-eye"></i></a>
                                    <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-sm btn-warning"><i
                                            class="fa fa-edit"></i></a>
                                    <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this ticket?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted py-4">No tickets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>



    <script>
        $(document).ready(function () {

            // 🟢 Update Ticket Status
            $(document).on('change', '.ticket-status', function () {
                const ticketId = $(this).data('id');
                const newStatus = $(this).val();

                if (!confirm(`Change status to "${newStatus}"?`)) return;

                $.ajax({
                    url: "{{ route('admin.tickets.update_status') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ticket_id: ticketId,
                        status: newStatus
                    },
                    success: function (res) {
                        if (res.success) {
                            alert(res.message);
                        } else {
                            alert('Failed to update status.');
                        }
                    },
                    error: function () {
                        alert('Error updating status.');
                    }
                });
            });


            // 🟢 Update Ticket Priority
            $(document).on('change', '.ticket-priority', function () {
                const ticketId = $(this).data('id');
                const newPriority = $(this).val();

                if (!confirm(`Change priority to "${newPriority}"?`)) return;

                $.ajax({
                    url: "{{ route('admin.tickets.update_priority') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ticket_id: ticketId,
                        priority: newPriority
                    },
                    success: function (res) {
                        if (res.success) {
                            alert(res.message);
                        } else {
                            alert('Failed to update priority.');
                        }
                    },
                    error: function () {
                        alert('Error updating priority.');
                    }
                });
            });

        });


    </script>
@endpush