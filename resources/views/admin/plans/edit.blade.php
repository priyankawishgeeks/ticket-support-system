@extends('layouts.admin')
@section('page_title', 'Edit Plan')

@section('content')
    <div class="card">
        <div class="card-header bg-warning text-white">Edit Plan</div>
        <div class="card-body">
            <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $plan->title) }}"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $plan->slug) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control"
                            value="{{ old('price', $plan->price) }}" required>
                    </div>

                    {{-- <div class="col-md-4 mb-3">
                        <label class="form-label">Currency</label>
                        <input type="text" name="currency" class="form-control"
                            value="{{ old('currency', $plan->currency) }}">
                    </div> --}}

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Currency</label>
                        <select name="currency" class="form-select">
                            @php
                                $currencies = ['USD', 'EUR', 'GBP', 'INR', 'AUD', 'CAD', 'JPY', 'CNY'];
                            @endphp
                            @foreach($currencies as $currency)
                                <option value="{{ $currency }}" {{ old('currency', 'USD') == $currency ? 'selected' : '' }}>
                                    {{ $currency }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Duration (days)</label>
                        <input type="number" name="duration_days" class="form-control"
                            value="{{ old('duration_days', $plan->duration_days) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Billing Cycle</label>
                        <select name="billing_cycle" class="form-select">
                            <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            <option value="one-time" {{ old('billing_cycle', $plan->billing_cycle) == 'one-time' ? 'selected' : '' }}>One-Time</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Trial Days</label>
                        <input type="number" name="trial_days" class="form-control"
                            value="{{ old('trial_days', $plan->trial_days) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Max Users</label>
                        <input type="number" name="max_users" class="form-control"
                            value="{{ old('max_users', $plan->max_users) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Max Storage (GB)</label>
                        <input type="number" name="max_storage_gb" class="form-control"
                            value="{{ old('max_storage_gb', $plan->max_storage_gb) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Max Projects</label>
                        <input type="number" name="max_projects" class="form-control"
                            value="{{ old('max_projects', $plan->max_projects) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Border Color</label>
                        <input type="color" name="border_color" class="form-control form-control-color"
                            value="{{ old('border_color', $plan->border_color) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Title Color</label>
                        <input type="color" name="title_color" class="form-control form-control-color"
                            value="{{ old('title_color', $plan->title_color) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Background Color</label>
                        <input type="color" name="background_color" class="form-control form-control-color"
                            value="{{ old('background_color', $plan->background_color) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Badge Label</label>
                        <input type="text" name="badge_label" class="form-control"
                            value="{{ old('badge_label', $plan->badge_label) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Renewal Type</label>
                        <select name="renewal_type" class="form-select">
                            <option value="auto" {{ old('renewal_type', $plan->renewal_type) == 'auto' ? 'selected' : '' }}>
                                Auto</option>
                            <option value="manual" {{ old('renewal_type', $plan->renewal_type) == 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Featured?</label>
                        <select name="is_featured" class="form-select">
                            <option value="1" {{ old('is_featured', $plan->is_featured) ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !old('is_featured', $plan->is_featured) ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Active?</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ old('is_active', $plan->is_active) ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !old('is_active', $plan->is_active) ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Features (JSON)</label>
                        <textarea name="features" class="form-control"
                            rows="3">{{ old('features', json_encode($plan->features, JSON_PRETTY_PRINT)) }}</textarea>
                        <small class="text-muted">Example: {"max_tickets":100,"support":true}</small>
                    </div>

                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Update Plan</button>
                </div>
            </form>
        </div>
    </div>
@endsection