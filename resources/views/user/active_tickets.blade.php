@extends('layouts.client')

@section('page_title', 'Active Tickets')

@section('client_content')
    <div class="container mt-4">
        <h4 class="mb-3"><i class="fa fa-ticket"></i> My Active Tickets</h4>
        <hr>

        @if($tickets->isEmpty())
            <div class="alert alert-info">You have no active tickets.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Track ID</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Replies</th>
                            <th>Last Reply</th>
                            <th>Assignee</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $key => $ticket)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $ticket->ticket_track_id }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>
                                    <span class="badge bg-success text-white">{{ ucfirst($ticket->status) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $ticket->replies_count }} {{-- ✅ reply count --}}
                                    </span>
                                </td>
                                <td>
                                    @if($ticket->replies->isNotEmpty())
                                        <small class="text-muted">
                                            {{ $ticket->replies->first()->created_at->diffForHumans() }}
                                            <br>
                                            <i class="fa fa-user text-secondary"></i>
                                            {{ $ticket->replies->first()->user ?? 'Unknown' }}
                                        </small>
                                    @else
                                        <span class="text-muted">No replies yet</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ticket->assignee)
                                        <div>
                                            <strong>{{ $ticket->assignee->title }} {{ $ticket->assignee->user }}</strong><br>
                                            <small>
                                                <i class="fa fa-envelope text-secondary"></i> {{ $ticket->assignee->email }}<br>
                                                <i class="fa fa-id-badge text-secondary"></i> Role ID:
                                                {{ $ticket->assignee->role->role_name }}<br>

                                            </small>
                                        </div>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>

                                <td>{{ $ticket->created_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    <a href="{{ route('user.ticket.detail', $ticket->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection