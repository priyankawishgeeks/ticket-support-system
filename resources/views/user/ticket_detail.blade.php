@extends('layouts.client')
@section('page_title', 'Ticket Details')

@section('client_content')
    <div class="container mt-4 mb-5">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
            <div class="col-8">
                {{-- 💬 Conversation --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">💬 Conversation</h6>
                    </div>
                    <div class="card-body" id="repliesContainer" style="max-height: 670px; overflow-y: auto;">

                        @forelse($ticket->replies as $reply)
                            @php
                                $isStaff = $reply->created_by_type === 'site_user';
                                $senderName = $isStaff
                                    ? ($reply->siteUser->username ?? 'You')
                                    : ($reply->appUser->user ?? 'Support Team');

                                $attachments = is_string($reply->attachments)
                                    ? json_decode($reply->attachments, true)
                                    : ($reply->attachments ?? []);
                            @endphp

                            <div
                                class="reply-wrapper d-flex {{ $isStaff ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                                <div class="p-3 rounded shadow-sm {{ $isStaff ? 'bg-light' : 'bg-primary bg-opacity-10' }}"
                                    style="max-width: 75%;">
                                    <div class="fw-semibold mb-1">{{ $senderName }}</div>
                                    <div class="text-break">{{ $reply->reply_body }}</div>

                                    @if(!empty($attachments))
                                        <ul class="list-unstyled small mt-2">
                                            @foreach($attachments as $att)
                                                <li>
                                                    <a href="{{ asset('storage/' . ($att['file_path'] ?? '')) }}" target="_blank"
                                                        class="text-decoration-none">
                                                        📎 {{ $att['file_name'] ?? 'Unnamed File' }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <div class="small text-muted mt-2">{{ $reply->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                            </div>

                        @empty
                            <p class="text-muted text-center m-0">No replies yet.</p>
                        @endforelse

                    </div>


                </div>

                {{-- ✏️ Reply Form --}}

            </div>


            <div class="col-4">
                <h4 class="fw-bold mb-3">🎫 Ticket Details</h4>
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="text-primary">{{ $ticket->title }}</h5>
                        <p class="text-muted mb-2">
                            <strong>Ticket ID:</strong> {{ $ticket->ticket_track_id }} |
                            <strong>Priority:</strong>
                            <span
                                class="badge bg-{{ strtolower($ticket->priority) === 'urgent' ? 'danger' : (strtolower($ticket->priority) === 'high' ? 'warning' : 'secondary') }}">
                                {{ $ticket->priority }}
                            </span>
                        </p>
                        <p><strong>Category:</strong> {{ $ticket->category->name ?? 'N/A' }}</p>
                        <p><strong>Subcategory:</strong> {{ $ticket->subcategory->name ?? 'N/A' }}</p>
                        <p><strong>Service:</strong> {{ $ticket->service->name ?? 'N/A' }}</p>
                        <p>

                            <strong>Support Assignee:</strong>
                            @if($ticket->assigned_to && $ticket->assignee)
                                            <div class="card mt-3">
                                                <div class="card-body d-flex align-items-center">
                                                    {{-- 👤 Profile Image --}}
                                                    <img src="{{ $ticket->assignee->img_url
                                ? asset($ticket->assignee->img_url)
                                : asset('images/default-user.png') }}" alt="Assigned User" class="rounded-circle me-3"
                                                        style="width: 60px; height: 60px; object-fit: cover;">

                                                    <div>
                                                        <h6 class="mb-1">
                                                            {{ $ticket->assignee->full_name ?? $ticket->assignee->user }}
                                                        </h6>
                                                        <p class="mb-0 text-muted">
                                                            <i class="fas fa-envelope"></i> {{ $ticket->assignee->email }}<br>
                                                            <i class="fas fa-phone"></i> {{ $ticket->assignee->contact_number ?? 'N/A' }}
                                                        </p>

                                                        <span class="badge bg-info mt-2">
                                                            {{ $ticket->assignee->role->role_name ?? 'No Role Assigned' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                            @else
                            <p class="text-muted mt-2">No agent assigned yet.</p>
                        @endif
                        <br>

                        </p>
                        @if($ticket->service_url)
                            <p><strong>Service URL:</strong>
                                <a href="{{ $ticket->service_url }}" target="_blank">{{ $ticket->service_url }}</a>
                            </p>
                        @endif

                        <p class="mt-3">{{ $ticket->ticket_body }}</p>

                        @if($ticket->attachments->count())
                            <div class="mt-3">
                                <strong>📎 Attachments:</strong>
                                <ul class="list-unstyled mt-2">
                                    @foreach($ticket->attachments as $file)
                                        @php
                                            // Full path for asset
                                            $filePath = asset('storage/' . $file->file_path);
                                            // Detect file type by extension
                                            $extension = strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION));
                                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif']);
                                        @endphp

                                        <li class="mb-2">
                                            <a href="{{ $filePath }}" target="_blank" class="text-decoration-none">
                                                {{ $file->file_name }}
                                            </a>

                                            {{-- 🖼️ Show image preview if it's an image --}}
                                            @if($isImage)
                                                <div class="mt-2">
                                                    <img src="{{ $filePath }}" alt="{{ $file->file_name }}" class="img-thumbnail"
                                                        style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0">✏️ Add a Reply</h6>
                </div>
                <div class="card-body">
                    <form id="replyForm" enctype="multipart/form-data">
                        @csrf
                        <textarea name="reply_body" class="form-control mb-2" rows="3" placeholder="Type your reply..."
                            required></textarea>
                        <input type="file" name="attachments[]" multiple class="form-control mb-3">
                        <button type="submit" class="btn btn-primary" id="sendReplyBtn">Send Reply</button>
                    </form>
                </div>
            </div>
        </div>



    </div>
@endsection

@push('scripts')

    <script>
        // Auto-reload page every 60 seconds
        setInterval(function () {
            window.location.reload();
        }, 60000); // 60,000 ms = 1 minute
    </script>


    <script>
        $(document).ready(function () {
            $('#replyForm').on('submit', function (e) {
                e.preventDefault();
                const btn = $('#sendReplyBtn');
                btn.prop('disabled', true).text('Sending...');

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('user.ticket.reply', $ticket->id) }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        console.log(res);
                        location.reload();
                    }
                    ,
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('⚠️ Failed to send reply. Please try again.');
                    },
                    complete: function () {
                        btn.prop('disabled', false).text('Send Reply');
                    }
                });
            });

        });
    </script>
@endpush