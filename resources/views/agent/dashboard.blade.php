@extends('layouts.staff')


@section('staff')
    <!-- Dashboard Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="dashboard-card bg-primary blur-bg">
                <h5>Assigned Tickets</h5>
                <p>{{  $assingnedTickets  }}</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="dashboard-card bg-success blur-bg">
                <h5>Open Tickets</h5>
                <p>{{  $activeTickets }}</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="dashboard-card bg-danger blur-bg">
                <h5>Closed Tickets</h5>
                <p>{{   $closedTickets }}</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="dashboard-card bg-warning blur-bg">
                <h5>Total Users</h5>
                <p>{{ $totalUsers }}</p>
            </div>
        </div>
    </div>

    <!-- Assigned Tickets Table -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Assigned Tickets</div>
                <div class="card-body">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Tickets</th>
                                <th>Priority</th>
                                <th>Plan</th>
                                <th>Last Reply</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignedSiteUsers as $user)
                                @foreach ($user->tickets as $ticket)
                                                @php
                                                    $borderColor = $user->activeSubscription?->currentPlan?->border_color
                                                        ?? $user->currentPlan?->border_color
                                                        ?? '#ddd';
                                                    $planTitle = $user->activeSubscription?->currentPlan?->title
                                                        ?? $user->currentPlan?->title
                                                        ?? 'No active plan';
                                                @endphp

                                                <tr>
                                                    <td>{{ $user->id }}</td>

                                                    {{-- User Column --}}
                                                    <td class="">
                                                        {{-- Profile Image with Plan Border --}}
                                                        @if ($user->photo_url)
                                                            <img src="{{ asset($user->photo_url) }}" alt="User" width="40" height="40"
                                                                title="{{ $planTitle }}" class="rounded-circle"
                                                                style="border: 3px solid {{ $borderColor }}; padding: 2px;">
                                                        @else
                                                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                                                style="width: 40px; height: 40px; border: 3px solid {{ $borderColor }}; background: #f8f9fa;">
                                                                <i class="fa fa-user text-muted"></i>
                                                            </div>
                                                        @endif

                                                        {{-- Username --}}
                                                        <a href="javascript:void(0);" class="btn btn-sm viewUserBtn" data-id="{{ $user->id }}"
                                                            style="border: 2px solid {{ $borderColor }};">
                                                            <i class="fa fa-eye"></i> {{ $user->username }}
                                                        </a>
                                                    </td>

                                                    {{-- Email --}}
                                                    <td>{{ $user->email }}</td>

                                                    {{-- Account Status --}}
                                                    <td>
                                                        @if($user->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>

                                                    {{-- Ticket Info --}}
                                                    <td>
                                                        <strong>#{{ $ticket->ticket_track_id }}</strong> <br>
                                                        <small>{{ $ticket->title }}</small> <br>
                                                        <span class="badge 
                                                    {{ $ticket->status === 'closed' ? 'bg-secondary' :
                                    ($ticket->status === 'pending' ? 'bg-warning text-dark' : 'bg-info') }}">
                                                            {{ ucfirst($ticket->status) }}
                                                        </span>
                                                    </td>

                                                    {{-- Priority --}}
                                                    <td>
                                                        <span class="badge 
                                                    {{ $ticket->priority === 'high' ? 'bg-danger' :
                                    ($ticket->priority === 'medium' ? 'bg-warning text-dark' : 'bg-success') }}">
                                                            {{ ucfirst($ticket->priority ?? 'normal') }}
                                                        </span>
                                                    </td>

                                                    {{-- Subscription Plan --}}
                                                    <td>
                                                        <span class="badge" style="background-color: {{ $borderColor }}; color: #fff;">
                                                            {{ $planTitle }}
                                                        </span>
                                                    </td>

                                                    {{-- Last Reply Time --}}
                                                    <td>
                                                        @php
                                                            $lastReply = $ticket->replies->max('created_at');
                                                        @endphp
                                                        {{ $lastReply ? \Carbon\Carbon::parse($lastReply)->format('d M Y, h:i A') : '—' }}
                                                    </td>
                                                </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No tickets assigned to you.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Details Modal -->
    <div class="modal fade" id="ticketViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">🎫 Ticket Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- SECTION 1: Ticket + User Info -->
                    <div id="ticket-info-section"></div>
                    <hr>
                    <!-- SECTION 2: Conversation / Replies -->
                    <div id="ticket-replies-section"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- User Info Modal -->


    <!-- Live Chat & Ticket Replies -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Ticket Replies</span>
                    <button id="refreshReplies" class="btn btn-sm btn-outline-primary">🔄 Refresh</button>
                </div>
                <div class="card-body" id="ticketReplies">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ticket ID</th>
                                <th>User</th>
                                <th>Last Reply</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ticketReplies as $reply)
                                <tr>
                                    <td>{{ $reply->ticket->ticket_track_id ?? 'N/A' }}</td>
                                    <td>{{ $reply->user->username ?? 'Anonymous' }}</td>
                                    <td>{{ Str::limit($reply->reply_body, 40) }}</td>
                                    <td><a href="{{ route('agent.tickets.show', $reply->ticket->id) }}"
                                            class="btn btn-sm btn-info"><i class="fa fa-eye"></i>Reply</a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No replies yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <div class="col-md-6 mb-3">
            <!-- Chat Modal -->
            <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="chatModalLabel">Live Chat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="chatBody">
                            <div class="chat-message"><strong>User:</strong> Hello, any update?</div>
                            <div class="chat-message text-end text-success"><strong>Agent:</strong> We're checking your
                                issue.</div>
                        </div>
                        <div class="modal-footer">
                            <input type="text" id="chatInput" class="form-control" placeholder="Type a message...">
                            <button class="btn btn-primary" id="sendMessageBtn">Send</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openChat(ticketId) {
                    const modal = new bootstrap.Modal(document.getElementById('chatModal'));
                    document.getElementById('chatModalLabel').textContent = "Ticket Chat #" + ticketId;
                    modal.show();
                }

                // Dummy send message
                document.getElementById('sendMessageBtn').addEventListener('click', function () {
                    let input = document.getElementById('chatInput');
                    if (input.value.trim() !== '') {
                        let msg = `<div class="chat-message text-end text-primary"><strong>You:</strong> ${input.value}</div>`;
                        document.getElementById('chatBody').insertAdjacentHTML('beforeend', msg);
                        input.value = '';
                    }
                });
            </script>

        </div>




    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userInfoModal = document.getElementById('userInfoModal');
            userInfoModal.addEventListener('show.bs.modal', function (event) {
                const link = event.relatedTarget;
                document.getElementById('modalUsername').textContent = link.getAttribute('data-username');
                document.getElementById('modalEmail').textContent = link.getAttribute('data-email');
                document.getElementById('modalPhone').textContent = link.getAttribute('data-phone');
                document.getElementById('modalJoined').textContent = link.getAttribute('data-joined');
            });
        });
    </script>

    <script>setInterval(() => {
            fetch('/agent/replies/refresh')
                .then(res => res.text())
                .then(html => document.getElementById('ticketReplies').innerHTML = html);
        }, 10000);
    </script>

@endpush


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).on('click', '.viewUserBtn', function () {
            const userId = $(this).data('id');
            $('#ticketViewModal').modal('show');

            $('#ticket-info-section').html('<p>Loading user details...</p>');
            $('#ticket-replies-section').empty();

            $.ajax({
                url: "{{ route('agent.user.details') }}",
                type: 'GET',
                data: { id: userId },
                success: function (response) {

                    $('#ticket-info-section').html(response.user_html);
                    $('#ticket-replies-section').html(response.tickets_html);
                },
                error: function () {
                    $('#ticket-info-section').html('<div class="text-danger">Error loading user details.</div>');
                }
            });
        });
    </script>

@endpush