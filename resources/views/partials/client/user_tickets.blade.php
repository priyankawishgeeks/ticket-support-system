@if($user->tickets->count() > 0)
    @foreach($user->tickets as $ticket)
        <div class="mb-4 p-3 border rounded shadow-sm bg-light">
            <h6 class="text-primary mb-1">
                🎫 {{ $ticket->title }} 
                <small class="text-muted">({{ ucfirst($ticket->status) }}, {{ $ticket->created_at->format('d M Y') }})</small>
            </h6>

            <p class="mb-2">{{ $ticket->ticket_body }}</p>

            <div class="small text-muted mb-2">
                <strong>Category:</strong> {{ $ticket->category->name ?? '—' }} |
                <strong>Subcategory:</strong> {{ $ticket->subcategory->name ?? '—' }} |
                <strong>Service:</strong> {{ $ticket->service->name ?? '—' }}
            </div>

            @if($ticket->assignedUser)
                <div class="small text-muted">
                    <strong>Assigned To:</strong> {{ $ticket->assignedUser->name ?? '—' }}
                    @if($ticket->assignedUser->email)
                        <span>({{ $ticket->assignedUser->email }})</span>
                    @endif
                </div>
            @else
                <div class="small text-muted"><strong>Assigned To:</strong> Not Assigned</div>
            @endif

            {{-- Replies Section --}}
            @if($ticket->replies->count() > 0)
                <div class="ms-3 border-start ps-3 mt-3">
                    @foreach($ticket->replies->sortBy('created_at') as $reply)
                        <div class="mb-3">
                            <strong>{{ $reply->siteUser->username ?? 'System' }}</strong>
                            <small class="text-muted">– {{ $reply->created_at->format('d M Y h:i A') }}</small>
                            <p class="mb-1">{{ $reply->ticket_body }}</p>

                            {{-- Attachments (if any) --}}
                            {{-- @if($reply->attachments && count($reply->attachments) > 0)
                                <div class="ms-3">
                                    <strong>Attachments:</strong>
                                    <ul class="mb-1">
                                        @foreach ($reply->attachments as $file)
                                            <li>
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                    {{ basename($file->file_path) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
@else
    <div class="alert alert-info">No tickets found for this user.</div>
@endif
