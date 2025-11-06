@extends('layouts.client')

@section('title', 'Closed Tickets')

@section('client_content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 mb-3">
            <h4 class="mb-0"><i class="fa fa-ticket me-2"></i> Closed Tickets</h4>
            <hr>
        </div>

        <div class="col-12">
            @if($tickets->count())
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Ticket ID</th>
                                    <th>Title</th>
                                    <th>Priority</th>
                                    <th>Closed On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $index => $ticket)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="badge bg-secondary">{{ $ticket->ticket_track_id }}</span></td>
                                        <td>{{ Str::limit($ticket->title, 40) }}</td>
                                        <td>
                                            @php
                                                $badgeClass = match($ticket->priority) {
                                                    'Low' => 'bg-success',
                                                    'Medium' => 'bg-info',
                                                    'High' => 'bg-warning',
                                                    'Urgent', 'Critical' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $ticket->priority }}</span>
                                        </td>
                                        <td>{{ optional($ticket->updated_at)->format('M d, Y h:i A') }}</td>
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
                </div>
            @else
                <div class="alert alert-info text-center shadow-sm">
                    <i class="fa fa-info-circle me-2"></i> You have no closed tickets yet.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
