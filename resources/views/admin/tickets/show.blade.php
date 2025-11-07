@extends('layouts.admin')
@section('page_title', 'Ticket Details')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Left Section -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">🎫 Ticket Details</h5>
                        <span class=" small text-primary">{{ $ticket->ticket_track_id }}</span>
                    </div>
                    <div class="card-body py-0">
                        <!-- Ticket Title & Body -->
                        <h5 class="fw-bold">{{ $ticket->title }}</h5>
                        <p>{{ $ticket->ticket_body }}</p>
                        <div class=" shadow-sm  ">
                            <!-- 🎟️ Ticket Header -->
                            <div class="d-flex align-items-center   bg-white shadow-sm rounded-3 ">
                                <div class="text-center">
                                    @if(!empty($ticket->siteUser->photo_url))
                                        <img src="{{ asset($ticket->siteUser->photo_url) }}" class="rounded-circle border"
                                            width="55" height="55" alt="User">
                                    @else
                                        <img src="{{ asset('images/default-user.png') }}" class="rounded-circle border"
                                            width="55" height="55" alt="User">
                                    @endif
                                    <div class=" ms-3">
                                        <h5 class="mb-0">{{ $ticket->siteUser->username ?? 'Unknown User' }}</h5>
                                        <small class="text-muted">
                                            Opened:
                                            {{ \Carbon\Carbon::parse($ticket->opened_time)->format('d M Y, h:i A') }}
                                        </small>
                                    </div>
                                </div>

                                <!-- 💬 Ticket Conversation -->
                                <div class="flex-grow-1  ">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">💬 Conversation</h5>
                                        <small class="text-muted">All public and internal replies</small>
                                    </div>

                                    <div class="card-body" id="ticket_replies_box"
                                        style="max-height: 420px; overflow-y: auto;">
                                        <div class="text-center text-muted py-3" id="no_replies">
                                            <em>No replies yet.</em>
                                        </div>
                                    </div>


                                </div>
                            </div>


                        </div>





                        <hr>

                        <!-- Current Status -->
                        <div class="fw-bold">
                            Current Ticket Status :
                            <span class="text-primary">🟢 {{ ucfirst($ticket->status) }}</span>
                        </div>
                        <hr>



                        <div class="mt-4 border p-3 rounded bg-light">
                            <label class="fw-bold mb-2">Reply To Ticket</label>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="fw-bold">Canned Messages</div>
                                <select id="canned_message_select" class="form-select w-auto">
                                    <option value="">Choose...</option>
                                </select>
                            </div>

                            {{-- Preview box --}}
                            <div id="canned_message_preview" class="border rounded p-3 bg-white shadow-sm mb-3"
                                style="display:none;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 id="canned_title" class="fw-bold mb-2"></h6>
                                        <div id="canned_body" class="text-muted small"></div>
                                    </div>
                                    <button type="button" id="use_message_btn" class="btn btn-sm btn-primary ms-3">Use This
                                        Message</button>
                                </div>
                            </div>

                            {{-- Reply textarea --}}
                            <textarea id="reply_body" name="reply_body" class="form-control" rows="5"
                                placeholder="Type your reply..."></textarea>
                            <input type="file" id="attachments" name="attachments[]" class="form-control my-2 w-50"
                                multiple>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                {{-- Status --}}
                                <div class="d-flex align-items-center w-50 me-3">
                                    <label for="status" class="fw-bold mb-0 me-2">Set Status:</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="New">New</option>
                                        <option value="Open">Open</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="On Hold">On Hold</option>
                                        <option value="Waiting for Customer">Waiting for Customer</option>
                                        <option value="Resolved">Resolved</option>
                                        <option value="Closed">Closed</option>
                                        <option value="Reopened">Reopened</option>
                                    </select>
                                </div>

                            

                                {{-- Reply Button --}}
                                <button class="btn btn-success w-25" type="button" id="reply_submit_btn">Reply</button>
                            </div>

                        </div>


                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-lg-4">
                <!-- Ticket Info -->
                <div class="card mb-3">
                    <div class="card-header bg-light fw-bold">Ticket Information</div>
                    <div class="card-body small">
                        <p><strong>Ticket Track ID:</strong> {{ $ticket->ticket_track_id }}</p>
                        <p><strong>Ticket User:</strong> {{ $ticket->siteUser->username ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $ticket->siteUser->email ?? 'N/A' }}</p>
                        <p><strong>Priority:</strong> {{ ucfirst($ticket->priority) }}</p>
                        <p><strong>Category:</strong> {{ $ticket->category->name ?? 'N/A' }}</p>
                        <p><strong>Subcategory:</strong> {{ $ticket->subcategory->name ?? 'N/A' }}</p>
                        <p><strong>Service:</strong> {{ $ticket->service->name ?? 'N/A' }}</p>
                        <p><strong>Service URL:</strong> {{ $ticket->service_url ?? '-' }}</p>

                        <p class="mt-2"><strong>Assigned On:</strong>
                            @if(is_null($ticket->assigned_to))
                                <a href="{{ route('admin.tickets.set_assign', $ticket->id) }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-person-plus-fill"></i> Set Assign
                                </a>
                            @else
                                <div class="d-flex align-items-center mt-2">
                                    @if(!empty($ticket->assignee->img_url))
                                        <img src="{{ asset($ticket->assignee->img_url) }}" class="rounded-circle" width="35"
                                            height="35">
                                    @else
                                        <img src="{{ asset('images/default-user.png') }}" class="rounded-circle" width="35" height="35">
                                    @endif
                                    <div class="ms-2">
                                        <div class="fw-bold">{{ $ticket->assignee->user ?? 'App User' }}</div>
                                        <small class="text-muted">{{ $ticket->assignee->role->role_name ?? 'No Role' }}</small>
                                    </div>
                                </div>
                            @endif
                        </p>

                        <p><strong>Opened:</strong> {{ $ticket->opened_time }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>

                        <p><strong>Last Updated:</strong> {{ $ticket->updated_at->diffForHumans() }}</p>


                    </div>
                    <hr>
                    <!-- Attachments Section -->
                    @if($ticket->attachments && $ticket->attachments->count())
                        <div class="m-2">
                            <h6 class="fw-bold mb-1">📎 Attachments</h6>
                            <div class="d-flex flex-wrap gap-3 mt-2">
                                @foreach($ticket->attachments as $file)
                                    @php
                                        $isImage = in_array(strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    @endphp

                                    @if($isImage)
                                        <!-- Image thumbnail -->
                                        <div class="border p-2 rounded bg-light text-center" style="width: 120px;">
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $file->file_path) }}" alt="{{ $file->file_name }}"
                                                    class="img-fluid rounded mb-1" style="max-height: 100px;">
                                            </a>
                                            <div class="small text-truncate">{{ $file->file_name }}</div>
                                        </div>
                                    @else
                                        <!-- Non-image file -->
                                        <div class="border p-2 rounded bg-light d-flex align-items-center">
                                            <i class="bi bi-paperclip me-2"></i>
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                class="text-decoration-none small">
                                                {{ $file->file_name }}
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="text-muted mt-3">No attachments found.</p>
                    @endif

                </div>

                <!-- Admin Notes -->
                <!-- Admin Notes -->
                <div class="card mb-3" id="admin-notes-card">
                    <div
                        class="card-header bg-success text-white fw-bold d-flex justify-content-between align-items-center">
                        <span>Admin Notes</span>
                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="collapse"
                            data-bs-target="#addNoteForm">
                            + Add Note
                        </button>
                    </div>

                    <div class="card-body">
                        @if($ticket->adminNotes->isEmpty())
                            <div class="small text-muted"><em>No notes found</em></div>
                        @else
                            @foreach($ticket->adminNotes()->latest()->get() as $note)
                                <div class="border-bottom mb-3 pb-2">
                                    <div class="d-flex justify-content-between">

                                        <strong>{{ $note->creator->user }}</strong> --
                                        <strong>
                                            {{ $note->creator->role->role_name }}
                                        </strong>
                                        <br>
                                        <span class="text-muted small">
                                            {{ $note->created_at->format('d M Y, h:i A') }}
                                        </span>
                                    </div>
                                    <div
                                        class="badge bg-{{ $note->visibility === 'team' ? 'info' : ($note->visibility === 'public' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($note->visibility) }}

                                    </div>
                                    @if($note->title)
                                        <div class="fw-semibold mt-1">{{ $note->title }}</div>
                                    @endif
                                    <div class="text-muted small mt-1">{!! nl2br(e($note->body)) !!}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Collapsible Add Note Form -->
                    <div class="collapse" id="addNoteForm">
                        <div class="card-footer bg-light">
                            <form action="{{ route('admin.notes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <input type="hidden" name="ticket_track_id" value="{{ $ticket->ticket_track_id }}">
                                <input type="hidden" name="note_type" value="Ticket-Replies">
                               <input type="hidden" name="client_id" value="{{  $ticket->siteUser->id  }}">
                                

                                <div class="mb-2">
                                    <label class="form-label small">Title</label>
                                    <input type="text" name="title" class="form-control form-control-sm"
                                        placeholder="Optional short title">
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small">Note</label>
                                    <textarea name="body" rows="3" class="form-control form-control-sm"
                                        placeholder="Write your note here..." required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label small">Visibility</label>
                                        <select name="visibility" class="form-select form-select-sm">
                                            <option value="private">Private (Only Me)</option>
                                            <option value="team">Team (All Admins)</option>
                                            <option value="public">Public (Visible to Client)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2 d-flex align-items-end justify-content-end">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            💾 Save Note
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Admin Work Log -->
                <div class="card mb-3">
                    <div
                        class="card-header bg-success text-white fw-bold d-flex justify-content-between align-items-center">
                        <span>Admin Work Log -?</span>
                        <button class="btn btn-light btn-sm">+ Add Log</button>
                    </div>
                    <div class="card-body small text-muted">
                        <em>No work log found</em>
                    </div>
                </div>

                <!-- Ticket History -->
                <div class="card">
                    <div class="card-header bg-light fw-bold">Ticket History</div>
                    <div class="card-body small text-muted">
                        <p><strong>Opened By:</strong> {{ $ticket->siteUser->username ?? 'N/A' }} <br>
                            <small>{{ $ticket->opened_time }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('canned_message_select');
            const previewBox = document.getElementById('canned_message_preview');
            const titleEl = document.getElementById('canned_title');
            const bodyEl = document.getElementById('canned_body');
            const replyTextarea = document.getElementById('reply_body');
            const useMessageBtn = document.getElementById('use_message_btn');

            const categoryId = "{{ $ticket->cat_id ?? '' }}";
            const subcategoryId = "{{ $ticket->services_cat_id ?? '' }}";
            const serviceId = "{{ $ticket->services ?? '' }}";

            // Load canned messages from API
            async function loadCannedMessages() {
                const url = new URL("{{ route('admin.canned_messages.fetch') }}", window.location.origin);
                if (categoryId) url.searchParams.append('category_id', categoryId);
                if (subcategoryId) url.searchParams.append('subcategory_id', subcategoryId);
                if (serviceId) url.searchParams.append('service_id', serviceId);

                try {
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    const data = await res.json();

                    select.innerHTML = `<option value="">Choose...</option>`;
                    data.forEach(msg => {
                        const opt = document.createElement('option');
                        opt.value = msg.id;
                        opt.textContent = msg.is_global ? `🌍 ${msg.title}` : msg.title;
                        opt.dataset.body = msg.body;
                        opt.dataset.subject = msg.subject ?? '';
                        select.appendChild(opt);
                    });
                } catch (e) {
                    console.error("Failed to load canned messages:", e);
                }
            }

            // Show preview when selecting a canned message
            select.addEventListener('change', () => {
                const option = select.selectedOptions[0];
                if (!option || !option.value) {
                    previewBox.style.display = 'none';
                    return;
                }

                titleEl.textContent = option.textContent;
                bodyEl.innerHTML = option.dataset.body;
                previewBox.style.display = 'block';
            });

            // Insert message into reply textarea
            useMessageBtn.addEventListener('click', () => {
                const option = select.selectedOptions[0];
                if (!option || !option.value) return;

                // Remove HTML tags for plain text
                const plainText = option.dataset.body.replace(/<\/?[^>]+(>|$)/g, '');
                replyTextarea.value = plainText;
                replyTextarea.focus();
            });

            loadCannedMessages();
        });
    </script>


    <script>
        $(document).ready(function () {
            const ticketId = "{{ $ticket->id }}";

            // ✅ Load replies from DB
            function loadReplies() {
                $.ajax({
       url: "{{ url('tickets') }}/" + ticketId + "/replies",
                    method: 'GET',
                    success: function (res) {
                        const replies = res.data || [];
                        $('#ticket_replies_box').empty();

                        if (replies.length === 0) {
                            $('#ticket_replies_box').html('<div class="text-center text-muted py-3"><em>No replies yet.</em></div>');
                        } else {
                            replies.forEach(r => appendReply(r));
                        }

                        $('#ticket_replies_box').scrollTop($('#ticket_replies_box')[0].scrollHeight);
                    },
                    error: function () {
                        console.error("Failed to load replies");
                    }
                });
            }

            // ✅ Append reply bubble
            function appendReply(reply) {
                const isStaff = reply.created_by_type === 'app_user';
                const senderName = isStaff
                    ? (reply.app_user?.user ?? 'Staff')
                    : (reply.site_user?.username ?? 'Client');

                const bubbleClass = isStaff ? 'reply-bubble reply-staff' : 'reply-bubble reply-client';

                let attachmentsHTML = '';
                if (reply.attachments && reply.attachments.length > 0) {
                    attachmentsHTML = `
                        <ul class="list-unstyled small mt-2">
                            ${reply.attachments.map(att => {
                        const filePath = typeof att === 'string' ? att : att.file_path;
                        const fileName = typeof att === 'string'
                            ? filePath.split('/').pop()
                            : (att.file_name || filePath.split('/').pop());
                        return `
                                    <li>
                                        <a href="/storage/${filePath}" target="_blank">📎 ${fileName}</a>
                                    </li>`;
                    }).join('')}
                        </ul>`;
                }

                const html = `
                    <div class="reply-wrapper ${isStaff ? 'text-end' : 'text-start'} mb-3">
                        <div class="${bubbleClass}">
                            <div class="fw-semibold">${senderName}</div>
                            <div class="mt-1">${reply.reply_body}</div>
                            ${attachmentsHTML}
                            <div class="small text-muted mt-1">${new Date(reply.created_at).toLocaleString()}</div>
                        </div>
                    </div>`;
                $('#ticket_replies_box').append(html);
            }

            // ✅ Submit reply
            $('#reply_submit_btn').on('click', function (e) {
                e.preventDefault();

                let replyBody = $('#reply_body').val().trim();
                if (!replyBody) {
                    alert('Please enter your reply first.');
                    return;
                }

                let formData = new FormData();
                formData.append('ticket_id', ticketId);
                formData.append('reply_body', replyBody);
              
                formData.append('reply_type', 'public');
                formData.append('_token', '{{ csrf_token() }}');

                const files = $('#attachments')[0]?.files;
                if (files) {
                    for (let i = 0; i < files.length; i++) {
                        formData.append('attachments[]', files[i]);
                    }
                }

                $('#reply_submit_btn').prop('disabled', true).text('Sending...');

                
                $.ajax({
                    url: "{{ route('ticket.replies.store') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        $('#reply_submit_btn').prop('disabled', false).text('Reply');
                        if (res.success) {

                            console.log(res);
                            alert(res.message);
                            // 🟢 Reload replies from DB for accuracy
                            loadReplies();
                            // Clear input fields
                            $('#reply_body').val('');
                            


                        } else {
                            alert('Error: ' + (res.message ?? 'Unable to send reply.'));
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr);
                        alert('Something went wrong while sending reply.');
                        $('#reply_submit_btn').prop('disabled', false).text('Reply');
                    }
                });
            });

            // Initial load
            loadReplies();
        });
    </script>


@endpush



<style>
    #ticket_replies_box {
        background: #fafafa;
        padding: 15px;
        border-radius: 10px;
    }

    .reply-bubble {
        display: inline-block;
        padding: 12px 15px;
        border-radius: 12px;
        font-size: 14px;
        max-width: 80%;
        word-wrap: break-word;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .reply-staff {
        background-color: #e9ecef;
        color: #000;
        border-top-right-radius: 2px;
        margin-left: auto;
    }

    .reply-client {
        background-color: #d1f7d6;
        color: #000;
        border-top-left-radius: 2px;
        margin-right: auto;
    }

    .reply-wrapper .fw-semibold {
        font-size: 13px;
        color: #333;
    }

    .reply-wrapper .small.text-muted {
        font-size: 11px;
    }


    .reply-bubble {
        display: inline-block;
        padding: 10px 14px;
        border-radius: 12px;
        max-width: 80%;
    }

    .reply-staff {
        background-color: #e9f5ff;
        color: #0a58ca;
    }

    .reply-client {
        background-color: #f1f1f1;
        color: #333;
    }
</style>