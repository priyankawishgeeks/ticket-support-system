<div class="client-menu-sidebar">
    <div class="sidebar-nav">
        <div class="navbar navbar-expand-sm navbar-client-menu" role="navigation">
            <div class="navbar-collapse collapse sidebar-navbar-collapse">
                <ul class="client-my-menu list-group w-100 ">
                    <!-- Profile Section -->
                    <li class="list-group-item d-none d-sm-block text-center mb-4">
                        @php
                            $user = $user ?? Auth::guard('site_user')->user();
                            $subscription = $subscription ?? null;
                            $planName = 'Free Plan';
                            $borderColor = '#5BC0DE';
                            $labelColor = '#5BC0DE';
                            $labelText = 'Free Support';

                            if ($subscription && $subscription->plan) {
                                $planName = $subscription->plan->title;
                                $borderColor = $subscription->plan->border_color ?? '#000';
                                $labelColor = $subscription->plan->background_color ?? '#000';
                                $labelText = $subscription->plan->badge_label ?? ucfirst($planName) . ' Member';
                            }
                        @endphp

                        <div class="profile-container my-3">
                            <div class="outer-w">
                                <div class="profile-img position-relative"
                                    style="border: 5px solid {{ $borderColor }};">
                                    <span class="subscription-label"
                                        style="background: {{ $labelColor }}; color: #fff;">
                                        {{ $labelText }}
                                    </span>
                                    <img src="{{ $user->photo_url ? asset($user->photo_url) : asset('default-avatar.png') }}"
                                        alt="{{ $user->first_name }}" class="img-fluid rounded-circle">
                                </div>
                            </div>

                            <div class="mt-2 fw-bold">{{ $user->first_name }} {{ $user->last_name }}</div>
                            <small>{{ $user->email }}</small><br>
                            <small>Joined: {{ $user->created_at->format('M d, Y') }}</small>

                            <div class="mt-2 p-1 rounded" style="background: {{ $labelColor }}; color: #fff;">
                                <small>{{ $planName }}</small>
                            </div>
                        </div>
                    </li>

                    <!-- Menu Links -->
                    <li>
                        <a href="{{ route('user.dashboard') }}"
                            class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <i class="fa fa-th"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.tickets.active') }}"
                            class="{{ request()->routeIs('user.tickets.active') ? 'active' : '' }}">
                            <i class="fa fa-ticket"></i> Active Tickets
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.tickets.closed') }}"
                            class="{{ request()->routeIs('user.tickets.closed') ? 'active' : '' }}"><i
                                class="fa fa-ticket"></i> Closed Tickets</a>
                    </li>
                    <li>
                        <a href="{{ route('user.profile') }}"
                            class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
                            <i class="fa fa-ticket"></i> Profile</a>
                    </li>

                    <li>

                        <a href="{{ route('user.password.change') }}"
                            class="{{ request()->routeIs('user.password.change') ? 'active' : '' }}">
                            <i class="fa fa-ticket"></i> Change Password</a>

                    </li>

                    <!-- Logout -->
                    <li>
                        <form action="{{ route('client.logout') }}" method="POST" class="mt-2">
                            @csrf
                            <button class="btn btn-danger w-100"><i class="fa fa-sign-out"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>