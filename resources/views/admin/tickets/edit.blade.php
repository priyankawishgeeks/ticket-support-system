@extends('layouts.admin')
@section('page_title', 'Edit Ticket')

@section('content')
    <div class="container mt-4">
        <h4>✏️ Edit Ticket - {{ $ticket->ticket_track_id }}</h4>
        <hr>

        <form action="{{ route('admin.tickets.update', ['id' => $ticket->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">User Email</label>
                    <select name="ticket_user" id="ticket_user" class="form-select" required>
                        <option value="">Select User</option>
                        @foreach($siteUsers as $user)
                            <option value="{{ $user->id }}" {{ old('ticket_user', $ticket->ticket_user) == $user->id ? 'selected' : '' }}>
                                {{ $user->email }} ({{ $user->username }})
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Category --}}
                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <select name="cat_id" id="cat_id" class="form-select" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('cat_id', $ticket->cat_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Subcategory --}}
                <div class="col-md-4">
                    <label class="form-label">Subcategory</label>
                    <select name="subcat_id" id="subcat_id" class="form-select"
                        data-selected="{{ old('subcat_id', $ticket->subcat_id ?? '') }}">
                        <option value="">Select Subcategory</option>
                    </select>
                </div>

                {{-- Service --}}
                <div class="col-md-4">
                    <label class="form-label">Service</label>
                    <select name="service_id" id="service_id" class="form-select"
                        data-selected="{{ old('service_id', $ticket->service_id ?? '') }}">
                        <option value="">Select Service</option>
                    </select>
                </div>

                {{-- Title --}}
                <div class="col-md-12">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $ticket->title ?? '') }}"
                        required>
                </div>

                {{-- Description --}}
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="ticket_body" class="form-control" rows="4"
                        required>{{ old('ticket_body', $ticket->ticket_body ?? '') }}</textarea>
                </div>

                {{-- Attachments --}}
                <div class="col-md-12">
                    <label class="form-label">Attachments (multiple)</label>
                    <input type="file" name="attachments[]" class="form-control" multiple>

                    @if(!empty($ticket->attachments) && $ticket->attachments->count())
                        <div class="mt-3">
                            <label class="form-label fw-bold">Existing Attachments</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($ticket->attachments as $file)
                                    @php
                                        $fileUrl = asset('storage/' . $file->file_path);
                                        $isImage = in_array(strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    @endphp

                                    @if($isImage)
                                        <div class="border p-2 rounded bg-light" style="width: 120px; text-align: center;">
                                            <a href="{{ $fileUrl }}" target="_blank">
                                                <img src="{{ $fileUrl }}" alt="{{ $file->file_name }}" class="img-fluid rounded mb-1"
                                                    style="max-height: 100px;">
                                            </a>
                                            <div class="small text-truncate">{{ $file->file_name }}</div>
                                        </div>
                                    @else
                                        <div class="border p-2 rounded bg-light d-flex align-items-center">
                                            <a href="{{ $fileUrl }}" target="_blank" class="text-decoration-none">
                                                📎 {{ $file->file_name }}
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Assign --}}
                {{-- <div class="col-md-6">
                    <label class="form-label">Assign To</label>
                    <select name="assigned_to" class="form-select">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', $ticket->assigned_to ?? '') == $user->id ?
                            'selected' : '' }}>
                            {{ $user->username }}
                        </option>
                        @endforeach
                    </select>
                </div> --}}

                {{-- Priority --}}
                <div class="col-md-6">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        @foreach(['Low', 'Medium', 'High', 'Urgent'] as $p)
                            <option value="{{ $p }}" {{ old('priority', $ticket->priority ?? 'Medium') == $p ? 'selected' : '' }}>
                                {{ $p }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let selectedSubcat = $('#subcat_id').data('selected');
            let selectedService = $('#service_id').data('selected');

            // Load subcategories for selected category
            function loadSubcategories(catId, callback = null) {
                if (!catId) {
                    $('#subcat_id').html('<option value="">Select Subcategory</option>');
                    $('#service_id').html('<option value="">Select Service</option>');
                    return;
                }

                $.ajax({
                    url: `/admin/get-subcategories/${catId}`,
                    type: 'GET',
                    success: function (res) {
                        let options = '<option value="">Select Subcategory</option>';
                        $.each(res, function (_, subcat) {
                            options += `<option value="${subcat.id}" ${selectedSubcat == subcat.id ? 'selected' : ''}>${subcat.name}</option>`;
                        });
                        $('#subcat_id').html(options);

                        if (callback) callback();
                    }
                });
            }

            // Load services for selected subcategory
            function loadServices(subcatId) {
                if (!subcatId) {
                    $('#service_id').html('<option value="">Select Service</option>');
                    return;
                }

                $.ajax({
                    url: `/admin/get-services/${subcatId}`,
                    type: 'GET',
                    success: function (res) {
                        let options = '<option value="">Select Service</option>';
                        $.each(res, function (_, service) {
                            options += `<option value="${service.id}" ${selectedService == service.id ? 'selected' : ''}>${service.name}</option>`;
                        });
                        $('#service_id').html(options);
                    }
                });
            }

            // On category change
            $('#cat_id').change(function () {
                loadSubcategories($(this).val());
            });

            // On subcategory change
            $('#subcat_id').change(function () {
                loadServices($(this).val());
            });

            // --- On Edit: prepopulate ---
            let catId = $('#cat_id').val();
            if (catId) {
                loadSubcategories(catId, function () {
                    let subcatId = $('#subcat_id').data('selected');
                    if (subcatId) loadServices(subcatId);
                });
            }
        });
    </script>
@endpush