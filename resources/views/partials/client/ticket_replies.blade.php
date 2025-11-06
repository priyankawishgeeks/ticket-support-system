@foreach ($ticket->replies->sortBy('created_at') as $reply)
<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h6 class="mb-0">
                {{ $reply->user->name ?? 'System' }}
                <small class="text-muted">({{ $reply->user->role ?? 'User' }})</small>
            </h6>
            <small class="text-muted">{{ $reply->created_at->format('d M Y h:i A') }}</small>
        </div>
        <p class="mt-2">{{ $reply->message }}</p>

        {{-- Attachments --}}
        @if($reply->attachments && $reply->attachments->count() > 0)
            <div class="mt-2">
                @foreach ($reply->attachments as $file)
                    @if(Str::endsWith($file->path, ['.jpg', '.jpeg', '.png', '.gif']))
                        <img src="{{ asset('storage/' . $file->path) }}" 
                             alt="Attachment" 
                             class="img-fluid rounded mb-2" 
                             style="max-height: 150px;">
                    @else
                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="d-block">
                            📎 {{ basename($file->path) }}
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endforeach
