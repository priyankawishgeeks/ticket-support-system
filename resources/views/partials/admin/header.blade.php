   <nav class="navbar navbar-light bg-light mb-4">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <!-- 🔙 Back Button -->
                        <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm mx-3">
                            &larr; Back
                        </a>

                        <!-- Page Title -->
                        <span class="navbar-brand mb-0 h1">@yield('page_title')</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center gap-4 ">
                    <!-- Logged-in Info -->
                    <div>Logged in as: <strong>{{ auth()->user()->user }}</strong></div>
                   <div class="dropdown me-3">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Internak IM
                        </button>

                        <div class="dropdown-menu dropdown-menu-end p-3"
                            style="width: 300px; max-height: 400px; overflow-y: auto;">
                            <div class="mb-2">
                                <label class="small fw-bold">To:</label>
                                <select id="chatUserSelect" class="form-select form-select-sm">
                                    <option value="">Select user...</option>
                                    @foreach(\App\Models\AppUser::all() as $user)
                                        @if(1)
                                            <option value="{{ $user->id }}">{{ $user->user }} -- {{ $user->role->role_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="small fw-bold">Related Ticket:</label>
                                <select id="chatTicketSelect" class="form-select form-select-sm">
                                    <option value="">(Optional)</option>
                                    @foreach(\App\Models\Ticket::select('id', 'ticket_track_id')->get() as $t)
                                        <option value="{{ $t->id }}">{{ $t->ticket_track_id }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="chatMessagesBox" class="border rounded p-2 mb-2 small"
                                style="height:150px; overflow-y:auto; background:#f8f9fa;">
                                <em>Select a user to start chatting...</em>
                            </div>

                            <div class="input-group input-group-sm">
                                <input type="text" id="chatMessageInput" class="form-control"
                                    placeholder="Type message..." disabled>
                                <button class="btn btn-primary" id="chatSendBtn" disabled>Send</button>
                            </div>
                        </div>
                    </div>


</div>
                </div>


            </nav>


            