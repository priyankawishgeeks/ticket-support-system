<div class="mb-3">
    <h5>{{ $ticket->subject }}</h5>
    <p class="text-muted mb-1">Ticket ID: <strong>#{{ $ticket->id }}</strong></p>
    <p><strong>Status:</strong> {{ $ticket->status }} | <strong>Priority:</strong> {{ $ticket->priority }}</p>
    <hr>
    <h6>👤 User Info</h6>
    <p><strong>Name:</strong> {{ $ticket->user->name }}</p>
    <p><strong>Email:</strong> {{ $ticket->user->email }}</p>
    <p><strong>Created:</strong> {{ $ticket->created_at->format('d M Y h:i A') }}</p>
</div>
