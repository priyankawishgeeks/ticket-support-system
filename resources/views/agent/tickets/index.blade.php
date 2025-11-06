@extends('layouts.staff')


@section('staff')


    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>🎫 All Active Tickets</h4>

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
                                    <a href="{{ route('agent.tickets.show', $ticket->id) }}"
                                        class="fw-semibold text-decoration-none">
                                        {{ Str::limit($ticket->title, 40) }}
                                    </a>
                                </td>

                                <td>{{ $ticket->category->name ?? '-' }}</td>
                                <td><span class="text-muted"
                                        title="{{ $ticket->opened_time }}">{{ $ticket->opened_time  }}</span></td>

                                {{-- Ticket User --}}
                                <td class="text-start">
                                    @if($ticket->siteUser?->profile_img)
                                        <img src="{{ asset('storage/' . $ticket->siteUser->profile_img) }}" alt="avatar" width="30"
                                            height="30" class="rounded-circle me-2">
                                    @else
                                        <span
                                            class="avatar-placeholder me-2 bg-secondary text-white rounded-circle d-inline-flex justify-content-center align-items-center"
                                            style="width:30px; height:30px;">
                                            {{ strtoupper(substr($ticket->siteUser->username ?? 'U', 0, 1)) }}
                                        </span>
                                    @endif
                                    {{ $ticket->siteUser->username ?? 'N/A' }}
                                </td>

                                {{-- Assigned User --}}
                                {{-- <td>{{ $ticket->assignee->user ?? '-' }}</td> --}}




                                <td><span class="badge bg-light text-dark">{{ $ticket->reply_counter }}</span></td>

                                {{-- Status --}}
                                <td>
                                    <span
                                        class="badge 
                                                                                                            @if($ticket->status === 'New') bg-primary
                                                                                                            @elseif($ticket->status === 'Closed') bg-dark
                                                                                                            @elseif($ticket->status === 'Pending') bg-warning
                                                                                                            @else bg-success @endif">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </td>

                                {{-- Priority --}}
                                <td>
                                    <span
                                        class="badge 
                                                                                                            @if($ticket->priority === 'High') bg-danger
                                                                                                            @elseif($ticket->priority === 'Medium') bg-info
                                                                                                            @else bg-secondary @endif">
                                        {{ $ticket->priority }}
                                    </span>
                                </td>

                                {{-- Last Reply --}}
                                <td><span class="text-muted"
                                        title="{{ $ticket->last_reply_time }}">{{ $ticket->last_reply_time  }}</span></td>

                                {{-- Actions --}}
                                <td class="text-end">
                                    <a href="{{ route('agent.tickets.show', $ticket->id) }}" class="btn btn-sm btn-info"><i
                                            class="fa fa-eye"></i></a>


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