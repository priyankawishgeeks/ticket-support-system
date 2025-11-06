@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Admin Dashboard')

@section('content')
    <!-- Dashboard Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Tickets</h5>
                    <p class="card-text">{{ $ticketCount }} Total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">{{ $siteUUserCount }} Total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Open Tickets</h5>
                    <p class="card-text">{{$ticketCount - $closedTickets }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Closed Tickets</h5>
                    <p class="card-text">{{ $closedTickets }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Recent Users</div>
                <div class="card-body">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Tickets</th>
                                <th>Replies</th>
                                <th>Last Login</th>
                                <th>Last Reply</th>
                            </tr>
                        </thead>
                        <tbody>



                            @forelse ($siteUser as $users)

                                @php
                                    $borderColor = $users->activeSubscription?->currentPlan?->border_color
                                        ?? $users->currentPlan?->border_color
                                        ?? '#ddd';
                                    $planTitle = $users->activeSubscription?->currentPlan?->title
                                        ?? $users->currentPlan?->title
                                        ?? 'No active plan';
                                @endphp

                                <tr>
                                    <td>{{ $users->id }}</td>

                                    <td class="d-flex align-items-center gap-2">
                                        {{-- Profile Image with Plan Border --}}
                                        @if ($users->photo_url)
                                            <img src="{{ asset($users->photo_url) }}" title="{{ $planTitle }}" alt="User" width="40"
                                                height="40" class="rounded-circle"
                                                style="border: 3px solid {{ $borderColor }}; padding: 2px;">
                                        @else
                                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; border: 3px solid {{ $borderColor }}; background: #f8f9fa;">
                                                <i class="fa fa-user text-muted"></i>
                                            </div>
                                        @endif

                                        {{-- Username with Modal Trigger --}}
                                        <a href="javascript:void(0);" class="btn btn-sm  viewAdminUserBtn"
                                            data-id="{{ $users->id }}"  style=" border: 3px solid {{ $borderColor }};">
                                            <i class="fa fa-eye"></i> {{ $users->username }}
                                        </a>
                                    </td>


                                    <td>
                                      <span class="badge bg-success">{{ $users->status }}</span>
                                    </td>

                                    <td>
                                        <span class="badge bg-info">{{ $users->tickets_count }}</span>
                                    </td>

                                    <td>
                                        <span class="badge bg-warning text-dark">{{ $users->ticket_replies_count }}</span>
                                    </td>

                                    <td>
                                        {{ $users->last_login_at ? $users->last_login_at->format('d M Y, h:i A') : '—' }}
                                    </td>

                                    <td>
                                        {{ $users->ticket_replies_max_created_at ? \Carbon\Carbon::parse($users->ticket_replies_max_created_at)->format('d M Y, h:i A') : '—' }}
                                    </td>
                                </tr>
                            @empty


                                <tr>
                                    <td colspan="7" class="text-center text-muted">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="adminUserViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">👤 User & Ticket Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- SECTION 1: User Info -->
                    <div id="admin-user-info-section"></div>
                    <hr>
                    <!-- SECTION 2: Tickets & Replies -->
                    <div id="admin-user-tickets-section"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Latest Ticket Replies -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">💬 Latest Ticket Replies</div>
                <div class="card-body" style="height: 600px; overflow-y: auto;" id="liveChatBox">

                    @forelse ($ticketReplies as $reply)
                        <div class="mb-2 p-2 border rounded shadow-sm">
                            <strong>From:</strong>
                            @if($reply->isFromAdmin())
                                {{ $reply->appUser?->name ?? 'Admin User' }}
                            @elseif($reply->isFromClient())
                                {{ $reply->siteUser?->username ?? 'Client User' }}
                            @else
                                Unknown
                            @endif
                            <br>

                            <strong>To:</strong>
                            @if($reply->isFromAdmin())
                                {{ $reply->siteUser?->username ?? 'Client' }}
                            @elseif($reply->isFromClient())
                                {{ $reply->appUser?->name ?? 'Admin' }}
                            @else
                                Unknown
                            @endif
                            <br>

                            <strong>Message:</strong> {{ $reply->reply_body }}
                            <br>

                            <strong>Status:</strong> {{ $reply->ticket?->status ?? 'N/A' }}
                            <br>

                            <strong>Read:</strong>
                            @if($reply->is_read)
                                ✅ Yes (at {{ optional($reply->read_at)->format('d M Y, h:i A') }})
                            @else
                                ❌ No
                            @endif
                            <br>

                            <small class="text-muted">Sent: {{ $reply->created_at->format('d M Y, h:i A') }}</small>
                            <div class="mt-2">
                                <a href="{{ route('admin.tickets.show', $reply->ticket_id) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i> View Conversation
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No recent chats found.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- 🔥 Dummy Live Chat Preview -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">🟢 Live Chat (Demo)</div>
                <div class="card-body" style="height: 600px; overflow-y: auto; background-color: #f9fafb;">
                    <div class="chat-message mb-3">
                        <div class="p-2 bg-light border rounded w-75">
                            <strong>Client (Priyanka):</strong><br>
                            Hi, I’m facing an issue with my printer. It keeps showing “Paper Jam”.
                            <br>
                            <small class="text-muted">10:32 AM</small>
                        </div>
                    </div>

                    <div class="chat-message text-end mb-3">
                        <div class="p-2 bg-primary text-white border rounded w-75 d-inline-block">
                            <strong>Admin (TechSupport):</strong><br>
                            Hello Priyanka! Please check if there’s any paper stuck in the rear tray.
                            <br>
                            <small>10:33 AM</small>
                        </div>
                    </div>

                    <div class="chat-message mb-3">
                        <div class="p-2 bg-light border rounded w-75">
                            <strong>Client (Priyanka):</strong><br>
                            I checked. There’s nothing stuck, but the error remains.
                            <br>
                            <small class="text-muted">10:34 AM</small>
                        </div>
                    </div>

                    <div class="chat-message text-end mb-3">
                        <div class="p-2 bg-primary text-white border rounded w-75 d-inline-block">
                            <strong>Admin (TechSupport):</strong><br>
                            Try turning the printer off for 30 seconds and power it back on.
                            <br>
                            <small>10:35 AM</small>
                        </div>
                    </div>

                    <div class="chat-message mb-3">
                        <div class="p-2 bg-light border rounded w-75">
                            <strong>Client (Priyanka):</strong><br>
                            That worked! Thank you. 😊
                            <br>
                            <small class="text-muted">10:36 AM</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {{-- <form id="dummyChatForm">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type a message..." disabled>
                            <button class="btn btn-secondary" type="button" disabled>Send</button>
                        </div>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        const chatForm = document.getElementById('chatForm');
        const chatBox = document.getElementById('liveChatBox');

        if (chatForm) {
            chatForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const msg = document.getElementById('chatMessage').value;
                if (msg.trim() !== '') {
                    const div = document.createElement('div');
                    div.innerHTML = `<strong>Admin:</strong> ${msg}`;
                    chatBox.appendChild(div);
                    chatBox.scrollTop = chatBox.scrollHeight;
                    chatForm.reset();
                }
            });
        }
    </script>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).on('click', '.viewAdminUserBtn', function () {
            const userId = $(this).data('id');
            $('#adminUserViewModal').modal('show');

            $('#admin-user-info-section').html('<p>Loading user details...</p>');
            $('#admin-user-tickets-section').empty();

            $.ajax({
                url: "{{ route('admin.user.details') }}",
                type: 'GET',
                data: { id: userId },
                success: function (response) {
                    $('#admin-user-info-section').html(response.user_html);
                    $('#admin-user-tickets-section').html(response.tickets_html);
                },
                error: function () {
                    $('#admin-user-info-section').html('<div class="text-danger">Error loading user details.</div>');
                }
            });
        });
    </script>
@endpush