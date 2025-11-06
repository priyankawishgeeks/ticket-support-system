@extends('layouts.client')

@section('title', 'Contact Support')

@section('client_content')
    <div class="container py-4">
        <h4 class="mb-4"><i class="fa fa-headset me-2"></i> Contact Support</h4>

        @if($tickets->count())
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Ticket ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Assigned Agent</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $i => $ticket)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><span class="badge bg-secondary">{{ $ticket->ticket_track_id }}</span></td>
                                    <td>{{ Str::limit($ticket->title, 40) }}</td>
                                    <td><span class="badge bg-info">{{ $ticket->status }}</span></td>
                                    <td>
                                        @if($ticket->assignedUser)
                                            {{ $ticket->assignedUser->user }}
                                        @else
                                            <span class="text-muted">Not assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($ticket->assignedUser)
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="collapse"
                                                data-bs-target="#agentInfo{{ $ticket->id }}">
                                                <i class="fa fa-eye"></i> View Agent
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>Awaiting Assignment</button>
                                        @endif
                                    </td>
                                </tr>

                                @if($ticket->assignedUser)
                                    <tr class="collapse bg-light" id="agentInfo{{ $ticket->id }}">
                                        <td colspan="6">
                                            <div class="p-3 d-flex align-items-center">
                                                <img src="{{ $ticket->assignedUser->img_url ? asset($ticket->assignedUser->img_url) : asset('images/default-avatar.png') }}"
                                                    alt="{{ $ticket->assignedUser->name }}" width="70" height="70"
                                                    class="rounded-circle me-3 border">
                                                <div>
                                                    <h6 class="mb-1">{{ $ticket->assignedUser->user }}</h6>
                                                    <p class="mb-1 small text-muted">
                                                        <i class="fa fa-envelope me-1"></i> {{ $ticket->assignedUser->email }}
                                                    </p>
                                                    @if($ticket->assignedUser->contact_number)
                                                        <p class="mb-1 small text-muted">
                                                            <i class="fa fa-phone me-1"></i> {{ $ticket->assignedUser->contact_number }}
                                                        </p>
                                                    @endif
                                                    <a href="mailto:{{ $ticket->assignedUser->email }}"
                                                        class="btn btn-sm btn-success mt-2">
                                                        <i class="fa fa-paper-plane"></i> Send Email
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fa fa-info-circle me-1"></i> You currently have no active tickets.
            </div>
        @endif
    </div>
@endsection
<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .collapse td {
        transition: background-color 0.3s ease;
    }
</style>