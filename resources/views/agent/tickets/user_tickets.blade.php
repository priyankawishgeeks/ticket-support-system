@extends('layouts.staff')

@section('page_title', 'All Site Users')

@section('staff')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">
                <i class="fas fa-users text-primary"></i> All Site Users
            </h4>
            <a href="{{ route('agent.dashboard') }}" class="btn btn-sm btn-secondary">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>

        @if ($users->count() > 0)
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-striped align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)

                            @php
                                $borderColor = $user->activeSubscription?->currentPlan?->border_color
                                    ?? $user->currentPlan?->border_color
                                    ?? '#ddd';
                                $planTitle = $user->activeSubscription?->currentPlan?->title
                                    ?? $user->currentPlan?->title
                                    ?? 'No active plan';
                            @endphp
                            <tr>
                                <td>{{ $users->firstItem() + $key }}</td>
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
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? '—' }}</td>
                                <td>{{ $user->city ?? '—' }}</td>
                                <td>{{ $user->country ?? '—' }}</td>
                                <td>
                                    @php
                                        $statusClass = $user->status === 'active'
                                            ? 'badge bg-success'
                                            : 'badge bg-secondary';
                                    @endphp
                                    <span class="{{ $statusClass }}">{{ ucfirst($user->status ?? 'Inactive') }}</span>
                                </td>
                                <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}</td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary viewUserBtn"
                                        data-id="{{ $user->id }}">
                                        <i class="fa fa-eye"></i> View
                                    </a>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

            <div class="mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info text-center py-4 shadow-sm">
                <i class="fa fa-info-circle"></i> No users found.
            </div>
        @endif
    </div>
@endsection

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