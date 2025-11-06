@extends('layouts.client')
@section('page_title', 'Ticket Details')

@section('client_content')
    <div class="container mt-5 mb-5">
        <h4>🎫 Ticket Information</h4>
        <hr>

        {{-- ✅ Success or error message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold">{{ $ticket->title }}</h5>
                <p class="text-muted mb-1">
                    <strong>Ticket ID:</strong> {{ $ticket->ticket_track_id }} <br>
                    <strong>Priority:</strong> {{ $ticket->priority }} <br>
                    <strong>Category:</strong> {{ $ticket->category->name ?? 'N/A' }} <br>
                    <strong>Subcategory:</strong> {{ $ticket->subcategory->name ?? 'N/A' }} <br>
                    <strong>Service:</strong> {{ $ticket->service->name ?? 'N/A' }} <br>

                    <strong>Support Assignee:</strong>
                    @if($ticket->assigned_to)
                        {{ $ticket->assigned_to->User ?? 'N/A' }}
                    @else
                        N/A
                    @endif <br>


                    <strong>Service URL:</strong>
                    @if($ticket->service_url)
                        <a href="{{ $ticket->service_url }}" target="_blank">{{ $ticket->service_url }}</a>
                    @else
                        N/A
                    @endif
                </p>
                <hr>
                <h6 class="fw-bold">Description:</h6>
                <p>{{ $ticket->ticket_body }}</p>
            </div>
        </div>

        {{-- Attachments --}}
        @if($ticket->attachments->count())
            <div class="card shadow-sm border-0 ">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">📎 Attachments</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($ticket->attachments as $file)
                            @php
                                $filePath = asset('storage/' . $file->file_path); // ✅ Correct: includes "storage/" prefix
                                $extension = strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif']);
                            @endphp

                            <li class="list-group-item">
                              

                                {{-- 🖼️ Show image preview if it's an image --}}
                                @if($isImage)
                                    <div class="mt-2 text-start">
                                        <img src="{{ $filePath }}" alt="{{ $file->file_name }}" class="img-thumbnail"
                                            style="max-width: 250px; max-height: 250px; object-fit: cover;">
                                    </div>
                                @endif
                                  <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $file->file_name }}</span>
                                  
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        @endif


        <div class="text-end mt-4">
            <a href="{{ route('user.ticket.detail', $ticket->id) }}" class="btn btn-primary">Ticket Details</a>
        </div>
    </div>
@endsection