@extends('layouts.admin')
@section('page_title', 'Edit Canned Message')

@section('content')
<div class="container mt-4">
    <h4>✏️ Edit Canned Message - {{ $cannedMessage->title }}</h4>
    <hr>

    <form action="{{ route('admin.canned_messages.update', $cannedMessage->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow-sm p-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="title" value="{{ $cannedMessage->title }}" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Subject</label>
                    <input type="text" name="subject" value="{{ $cannedMessage->subject }}" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Type</label>
                    <select name="type" class="form-select" required>
                        @foreach(['text', 'html', 'markdown'] as $type)
                            <option value="{{ $type }}" {{ $cannedMessage->type === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $cannedMessage->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Subcategory</label>
                    <select name="subcategory_id" class="form-select">
                        <option value="">Select Subcategory</option>
                        @foreach($subcategories as $sub)
                            <option value="{{ $sub->id }}" {{ $cannedMessage->subcategory_id == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Service</label>
                    <select name="service_id" class="form-select">
                        <option value="">Select Service</option>
                        @foreach($services as $srv)
                            <option value="{{ $srv->id }}" {{ $cannedMessage->service_id == $srv->id ? 'selected' : '' }}>
                                {{ $srv->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-bold">Body</label>
                    <textarea name="body" rows="5" class="form-control" required>{{ $cannedMessage->body }}</textarea>
                </div>

                <div class="col-md-4 mb-3 form-check">
                    <input type="checkbox" name="is_global" id="is_global"
                           class="form-check-input" {{ $cannedMessage->is_global ? 'checked' : '' }}>
                    <label for="is_global" class="form-check-label">Make Global</label>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ $cannedMessage->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $cannedMessage->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.canned_messages.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection
