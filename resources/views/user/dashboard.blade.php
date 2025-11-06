@extends('layouts.client')

@section('client_content')
    @php
        $user = Auth::guard('site_user')->user();
        $subscription = $subscription ?? null;
        $plan = $subscription?->plan;
        $planName = $plan?->title ?? 'Free Plan';
        $planColor = $plan?->border_color ?? '#5BC0DE';
        $isChatEnabled = in_array($plan?->id, [6, 7]);
        $isCallEnabled = ($plan?->id == 7);
    @endphp

    <style>
        .dashboard-card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            position: relative;
            min-height: 160px;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .blurred {
            filter: blur(1px);
            pointer-events: none;
            opacity: 0.8;
        }

        .subscribe-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
        }

        .subscribe-btn {
            background-color: #007BFF;
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
        }

        .subscribe-btn:hover {
            background-color: #0056B3;
        }
    </style>

    <div class="container py-4">

        <div class="row mb-4">


            <div class="col-md-12">
                <h5 class="mb-3">Your Current Ticket Status</h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <a href="{{ route('user.open_ticket') }}" class="text-decoration-none text-dark">
                            <div class="card dashboard-card text-center p-3">
                                <i class="fas fa-plus fa-2x mb-2 text-primary"></i>
                                <h6>Open Ticket</h6>
                                <small>Submit Your Inquiry</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 position-relative">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="card dashboard-card text-center p-3 {{ !$isChatEnabled ? 'blurred' : '' }}">
                                <i class="fas fa-comments fa-2x mb-2 text-primary"></i>
                                <h6>Live Chat Support</h6>
                                <small>Need Quick Assistance?</small>
                            </div>
                            @unless($isChatEnabled)
                                <div class="subscribe-overlay">
                                    <a href="{{ route('client.plans') }}" class="subscribe-btn">Upgrade Plan</a>
                                </div>
                            @endunless
                        </a>
                    </div>
                    <div class="col-md-4 position-relative">
                        <a href="{{ route('user.contact_support') }}" class="text-decoration-none text-dark">
                            <div class="card dashboard-card text-center p-3 {{ !$isCallEnabled ? 'blurred' : '' }}">
                                <i class="fas fa-phone fa-2x mb-2 text-success"></i>
                                <h6>Talk to an Agent</h6>
                                <small>Immediate Assistance</small>
                            </div>
                            @unless($isCallEnabled)
                                <div class="subscribe-overlay">
                                    <a href="{{ route('client.plans') }}" class="subscribe-btn">Upgrade Plan</a>
                                </div>
                            @endunless
                        </a>
                    </div>
                </div>

                <div class="row g-3 text-center">

                    <div class="col-md-4">
                        <div class="card p-3">


                            <h3 class="text-secondary">{{ $assignedtickets ?? 0 }}</h3>

                            <a href="{{ route('user.tickets.active') }}" class="text-reset  text-decoration-none p-4">
                                Tickets
                            </a>


                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card p-3">

                            <h3 class="text-success">{{ $activeTickets ?? 0 }}</h3>
                        <a href="{{ route('user.tickets.active') }}" class="text-reset text-decoration-none p-4">
                             Active Tickets
                            </a>



                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3">

                            <h3 class="text-warning">{{ $closedTickets ?? 0 }}</h3>
                        <a href="{{ route('user.tickets.closed') }}" class="text-reset text-decoration-none p-4">
                             Closed Tickets
                            </a>


                        </div>
                    </div>


                </div>

                <div class="text-center mt-4">
                    <h5>Thank you for being with us</h5>
                </div>
            </div>
        </div>

    </div>
@endsection