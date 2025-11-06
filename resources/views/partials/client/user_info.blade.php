<div>
    <h5>{{ $user->full_name ?? $user->username }}</h5>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Phone:</strong> {{ $user->phone ?? '—' }}</p>
    <p><strong>City:</strong> {{ $user->city ?? '—' }}</p>
    <p><strong>Country:</strong> {{ $user->country ?? '—' }}</p>
    <p><strong>Joined:</strong> {{ $user->created_at->format('d M Y h:i A') }}</p>
    <p><strong>Status:</strong> 
        <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
            {{ ucfirst($user->status) }}
        </span>
    </p>

    <hr>

    <p><strong>Account Status:</strong> 
        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
            {{ $user->is_active ? 'Active' : 'Inactive' }}
        </span> 
    </p>

    @if($user->activeSubscription)
        <hr>
        <h6 class="mt-3">Subscription Details</h6>
        <p><strong>Plan:</strong> {{ $user->activeSubscription->plan->title ?? '—' }}</p>
        <p><strong>Price:</strong> {{ $user->activeSubscription->plan->price ?? '—' }}</p>
        <p><strong>Start Date:</strong> {{ optional($user->activeSubscription->start_date)->format('d M Y') }}</p>
        <p><strong>End Date:</strong> {{ optional($user->activeSubscription->end_date)->format('d M Y') }}</p>
        <p><strong>Status:</strong> 
            <span class="badge {{ $user->activeSubscription->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                {{ ucfirst($user->activeSubscription->status) }}
            </span>
        </p>
    @else
        <hr>
        <h6 class="mt-3">Subscription Details</h6>
        <p class="text-muted">No active subscription</p>
    @endif
</div>
