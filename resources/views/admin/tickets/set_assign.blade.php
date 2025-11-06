@extends('layouts.admin')
@section('page_title', 'Assign Ticket')

@section('content')
    <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>🎟️ Assign Ticket #{{ $ticket->ticket_track_id ?? $ticket->id }}</h4>
            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Tickets
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong>Assign Ticket Details</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.tickets.assign.update', $ticket->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Ticket Info --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" class="form-control" value="{{ $ticket->title }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <span class="badge 
                                    @if($ticket->status === 'New') bg-primary 
                                    @elseif($ticket->status === 'Pending') bg-warning 
                                    @elseif($ticket->status === 'Closed') bg-dark 
                                    @else bg-success @endif">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Category & Subcategory --}}
                    {{-- <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $ticket->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div> --}}

                        {{-- <div class="col-md-6">
                            <label class="form-label fw-bold">Subcategory</label>
                            <select name="subcategory_id" class="form-select">
                                <option value="">Select Subcategory</option>
                                @foreach($subcategories as $sub)
                                <option value="{{ $sub->id }}" {{ $ticket->subcategory_id == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

                    {{-- Service --}}
                    {{-- <div class="mb-3">
                        <label class="form-label fw-bold">Service</label>
                        <select name="service_id" class="form-select">
                            <option value="">Select Service</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $ticket->service_id == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                            @endforeach
                        </select>
                    </div> --}}

                    {{-- Assign To --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold d-block">Assign To (App User)</label>

                        <div class="d-flex flex-wrap gap-3">
                            @foreach($appUser as $user)
                                @php
                                    $role = \App\Models\Role::find($user->role_id);
                                @endphp

                                <label class="border rounded-3 p-3 text-center shadow-sm" style="width: 180px;">
                                    <input type="radio" name="assigned_to" value="{{ $user->id }}" class="form-check-input mb-2"
                                        {{ $ticket->assigned_to == $user->id ? 'checked' : '' }} required>

                                    <div class="fw-bold">{{ $user->user ?? 'User #' . $user->id }}</div>
                                    <div class="text-muted small">{{ $user->panel ?? 'No Panel' }}</div>
                                    <div class="badge bg-secondary mt-1">
                                        {{ $role->role_name ?? 'No Role' }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>


                    {{-- Submit --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Assign Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection