@extends('layouts.client')

@section('title', 'My Profile')

@section('client_content')
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 text-center p-4">
                    <div class="profile-img mb-3">
                        <img src="{{ $user->photo_url ? asset( $user->photo_url) : asset('images/default-avatar.png') }}"
                            class="rounded-circle img-thumbnail" width="150" height="150" id="previewImage">
                    </div>
                    <h5 class="mb-1">{{ $user->full_name }}</h5>
                    <small class="text-muted">{{ $user->email }}</small>
                    <hr>
                    <p class="small text-muted mb-1"><strong>Member since:</strong>
                        {{ $user->created_at->format('M d, Y') }}</p>
                    <p class="small text-muted"><strong>Last Login:</strong>
                        {{ optional($user->last_login_at)->format('M d, Y h:i A') }}</p>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Edit Profile</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="">Select</option>
                                        <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob"
                                        value="{{ old('dob', optional($user->dob)->format('Y-m-d')) }}"
                                        class="form-control">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" value="{{ old('city', $user->city) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Region</label>
                                    <input type="text" name="region" value="{{ old('region', $user->region) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" value="{{ old('country', $user->country) }}"
                                        class="form-control">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Profile Picture</label>
                                    <input type="file" name="photo_url" class="form-control" accept="image/*"
                                        onchange="previewImage(event)">
                                </div>
                                

                                <div class="col-12">
                                    <label class="form-label">Bio</label>
                                    <textarea name="bio" class="form-control"
                                        rows="3">{{ old('bio', $user->bio) }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Website</label>
                                    <input type="url" name="website" value="{{ old('website', $user->website) }}"
                                        class="form-control">
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-success">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

             

                @if($subscription && $subscription->plan)
                    <div class="card mt-4 shadow-sm border-0">
                        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Your Subscription Details</h6>
                            <span class="badge bg-light text-success">{{ ucfirst($subscription->status) ?? 'Active' }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Plan Name:</strong> {{ $subscription->plan->title }}</p>
                                    <p class="mb-1"><strong>Price:</strong> {{ $subscription->plan->price }}
                                        {{ $subscription->plan->currency ?? 'USD' }}
                                    </p>
                                    <p class="mb-1"><strong>Duration:</strong> {{ $subscription->plan->duration ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Subscribed On:</strong>
                                        {{ $subscription->created_at->format('M d, Y') }}</p>
                                    <p class="mb-1"><strong>Expires On:</strong>
                                        @if($subscription->expires_at)
                                            {{ \Carbon\Carbon::parse($subscription->expires_at)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p class="mb-1"><strong>Auto Renewal:</strong>
                                        {{ $subscription->auto_renew ? 'Enabled' : 'Disabled' }}
                                    </p>
                                </div>

                             @php
    // Normalize features whether stored as JSON array or comma-separated string
    $features = [];

    if (!empty($plan->features)) {
        if (is_array($plan->features)) {
            $features = $plan->features;
        } elseif (is_string($plan->features)) {
            $features = array_map('trim', explode(',', $plan->features));
        }
    } elseif (!empty($subscription->plan->features)) {
        if (is_array($subscription->plan->features)) {
            $features = $subscription->plan->features;
        } elseif (is_string($subscription->plan->features)) {
            $features = array_map('trim', explode(',', $subscription->plan->features));
        }
    }
@endphp

@if(!empty($features))
    <div class="col-12 mt-2">
        <strong>Included Features:</strong>
        <ul class="list-group list-group-flush mt-2">
            @foreach($features as $feature)
                <li class="list-group-item">
                    <i class="fa fa-check text-success me-2"></i> {{ $feature }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

                            </div>
                        </div>
                    </div>
                @else
                    <div class="card mt-4 shadow-sm border-0">
                        <div class="card-body text-center text-muted">
                            <i class="fa fa-info-circle fa-2x mb-2 text-secondary"></i>
                            <p class="mb-0">You have no active subscription.</p>
                            <a href="{{ route('client.plans') }}" class="btn btn-outline-primary mt-2">View Available Plans</a>
                        </div>
                    </div>
                @endif


   @if($plans->count())
                    <div class="card mt-4 shadow-sm border-0">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">Your Available Plans</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($plans as $plan)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $plan->title }}</span>
                                        <span class="badge bg-primary">{{ $plan->price }} {{ $plan->currency ?? 'USD' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                document.getElementById('previewImage').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection