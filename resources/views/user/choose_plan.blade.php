@extends('layouts.client')

@section('client_content')
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-3 fw-bold">Choose Your Plan</h2>
        <p class="text-center text-muted mb-5">
            Select the perfect plan that fits your needs.<br>
            For assistance, contact
            <a href="https://www.wishgeeks.com/" target="_blank">WishGeeks Support</a>.
        </p>

        <div class="row justify-content-center">
            @forelse($plans as $plan)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card plan-card h-100 {{ $plan->is_featured ? 'border-primary shadow-lg' : '' }}"
                        style="border: 3px solid {{ $plan->border_color ?? '#ccc' }};">

                        <div class="card-body text-center">
                            {{-- Title --}}
                            <h4 class="card-title fw-bold" style="color: {{ $plan->title_color ?? '#000' }};">
                                {{ $plan->title }}
                            </h4>
                            <p class="text-muted small mb-2">
                                {{ $plan->badge_label ?? 'Subscription Plan' }}
                            </p>

                            {{-- Price --}}
                            <h5 class="price-tag mb-3">
                                ₹{{ number_format($plan->price, 2) }}
                                <small class="text-muted">/ {{ $plan->duration_days }} days</small>
                            </h5>

                            {{-- Features --}}
                            <div class="plan-features text-start mb-4 px-2">
                                @if(!empty($plan->features) && is_array($plan->features))
                                    <ul class="list-unstyled">
                                        @foreach($plan->features as $feature)
                                            <li>✅ {{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <ul class="list-unstyled">
                                        <li>👥 Max Users: {{ $plan->max_users ?? 'Unlimited' }}</li>
                                        <li>💾 Storage: {{ $plan->max_storage_gb ? $plan->max_storage_gb . ' GB' : 'Unlimited' }}
                                        </li>
                                        <li>📁 Projects: {{ $plan->max_projects ?? 'Unlimited' }}</li>
                                        <li>🔄 Renewal: {{ ucfirst($plan->renewal_type ?? 'manual') }}</li>
                                    </ul>
                                @endif
                            </div>

                            {{-- Trial & Buttons --}}
                            @if($plan->hasTrial())
                                <span class="badge bg-warning text-dark mb-2">
                                    🎁 Includes {{ $plan->trial_days }}-Day Free Trial
                                </span>
                            @endif

                            <a href="{{ route('client.checkout', $plan->id) }}" class="btn btn-primary w-100 fw-bold mt-2"
                                style="background: {{ $plan->background_color ?? '#007BFF' }};
                          border-color: {{ $plan->background_color ?? '#007BFF' }};">
                                Subscribe Now
                            </a>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-8 text-center">
                    <p class="alert alert-info">
                        No subscription plans found.<br>
                        Please contact <a href="https://www.wishgeeks.com/">WishGeeks</a> for details.
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Inline Styling --}}
    <style>
        .plan-card {
            border-radius: 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #fff;
        }

        .plan-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .price-tag {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .plan-features li {
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
    </style>
@endsection