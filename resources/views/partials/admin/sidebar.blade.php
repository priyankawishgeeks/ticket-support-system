<div class="sidebar d-flex flex-column p-3" id="sidebar">
    <h4 class="text-center py-3">Ticket Admin</h4>

    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
    </a>


    {{-- -User Setting --}}
    @php
        $AppUserMenuOpen = request()->routeIs('admin.app_user.*') || request()->routeIs('admin.roles.*');
    @endphp
    <a data-bs-toggle="collapse" href="#app_user_menu" role="button"
        aria-expanded="{{ $AppUserMenuOpen ? 'true' : 'false' }}">
        <i class="bi bi-person-gear iconStyle"></i> User Settings
    </a>
    <div class="collapse submenu {{ $AppUserMenuOpen ? 'show' : '' }}" id="app_user_menu">

        <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <i class="fas fa-user-tag me-2"></i> Role List
        </a>
        <a href="{{ route('admin.app_user.index') }}"
            class="{{ request()->routeIs('admin.app_user.*') ? 'active' : '' }}"> <i
                class="bi bi-person-workspace iconStyle"></i>All User List </a>

    </div>

    {{-- -Clients --}}


    @php
        $AppSiteMenuOpen = request()->routeIs('admin.site_user.*');
    @endphp
    <a data-bs-toggle="collapse" href="#site_user_menu" role="button"
        aria-expanded="{{ $AppSiteMenuOpen ? 'true' : 'false' }}">
        <i class="bi bi-people iconStyle"></i> Clients
    </a>
    <div class="collapse submenu {{ $AppSiteMenuOpen ? 'show' : '' }}" id="site_user_menu">

        <a href="{{ route('admin.site_user.index') }}"
            class="{{ request()->routeIs('admin.site_user.*') ? 'active' : '' }}">
            <i class="bi bi-person-check iconStyle"></i> Site User List
        </a>
    </div>


    {{-- Subscriptions --}}
    @php
        $subsMenuOpen = request()->routeIs('admin.plans.*') || request()->routeIs('admin.subscriptions.*') || request()->routeIs('admin.subscription_payments.*');
    @endphp
    <a data-bs-toggle="collapse" href="#subscriptionsMenu" role="button"
        aria-expanded="{{ $subsMenuOpen ? 'true' : 'false' }}">
        <i class="fas fa-gift me-2"></i> Subscriptions
    </a>
    <div class="collapse submenu {{ $subsMenuOpen ? 'show' : '' }}" id="subscriptionsMenu">
        <a href="{{ route('admin.plans.index') }}" class="{{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">All
            Plans</a>
        <a href="{{ route('admin.subscriptions.index') }}"
            class="{{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">All Subscriptions</a>
        <a href="{{ route('admin.subscription_payments.index') }}"
            class="{{ request()->routeIs('admin.subscription_payments.*') ? 'active' : '' }}">Pending Payments</a>
        <a href="{{ route('admin.expired_subscriptions.index') }}"
            class="{{ request()->routeIs('admin.expired_subscriptions.*') ? 'active' : '' }}">Expired Subscriptions</a>
    </div>



    {{-- Tickets --}}
    @php
        $ticketMenuOpen = request()->is('admin/ticket*');
    @endphp

    <a data-bs-toggle="collapse" href="#ticketsMenu" role="button"
        aria-expanded="{{ $ticketMenuOpen ? 'true' : 'false' }}">
        <i class="fas fa-ticket-alt me-2"></i> Tickets
    </a>
    <div class="collapse submenu {{ $ticketMenuOpen ? 'show' : '' }}" id="ticketsMenu">

        <a href="{{ route('admin.ticket_main_categories.index') }}"
            class="{{ request()->routeIs('admin.ticket_main_categories.*') ? 'active' : '' }}"> <i
                class="bi bi-record-circle-fill  "></i> Ticket Categories</a>

        <a href="{{ route('admin.ticket_subcategories.index') }}"
            class="{{ request()->routeIs('admin.ticket_subcategories.*') ? 'active' : '' }}"><i
                class="bi bi-record-circle-fill"></i> Ticket Sub-Categories</a>


        <a href="{{ route('admin.ticket_services.index') }}"
            class="{{ request()->routeIs('admin.ticket_services.*') ? 'active' : '' }}"><i
                class="bi bi-record-circle-fill"></i> Services</a>

        <a href="{{ route('admin.ticket_service_user.index') }}"
            class="{{ request()->routeIs('admin.ticket_service_user.*') ? 'active' : '' }}"><i
                class="bi bi-record-circle-fill"></i> User Services </a>
        <a href="{{ route('admin.tickets.create') }}"
            class="{{ request()->is('admin/tickets/create') ? 'active' : '' }}"><i class="bi bi-record-circle-fill"></i>
            Create Ticket</a>
        <a href="{{ route('admin.tickets.index') }}"
            class="{{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}"><i class="bi bi-record-circle-fill"></i>
            All Tickets</a>

    </div>

    @php
        $CannedMessageMenuOpen = request()->is('admin/canned_messages.*');
    @endphp
    <a data-bs-toggle="collapse" href="#cannedMessageMenu" role="button"
        aria-expanded="{{ $CannedMessageMenuOpen ? 'true' : 'false' }}">
        <i class="bi bi-chat-square-text iconStyle"></i> Canned Messages
    </a>
    <div class="collapse submenu {{ $CannedMessageMenuOpen ? 'show' : '' }}" id="cannedMessageMenu">
        <a href="{{ route('admin.canned_messages.index') }}"
            class="{{ request()->is('admin/canned_messages.*') ? 'active' : '' }}"><i
                class="bi bi-record-circle-fill"></i> Canned Messages </a>
    </div>

    {{-- Payments --}}
    @php
        $paymentsMenuOpen = request()->is('admin/payments*');
    @endphp
    <a data-bs-toggle="collapse" href="#paymentsMenu" role="button"
        aria-expanded="{{ $paymentsMenuOpen ? 'true' : 'false' }}">
        <i class="fas fa-credit-card me-2"></i> Payments
    </a>
    <div class="collapse submenu {{ $paymentsMenuOpen ? 'show' : '' }}" id="paymentsMenu">
        <a href="#" class="{{ request()->is('admin/payments') ? 'active' : '' }}">All Payments</a>
        <a href="#" class="{{ request()->is('admin/payments/pending') ? 'active' : '' }}">Pending Payments</a>
        <a href="#" class="{{ request()->is('admin/payments/reports') ? 'active' : '' }}">Revenue Reports</a>
    </div>

    {{-- Settings --}}
    @php
        $settingsMenuOpen = request()->is('admin/settings*');
    @endphp
    <a data-bs-toggle="collapse" href="#settingsMenu" role="button"
        aria-expanded="{{ $settingsMenuOpen ? 'true' : 'false' }}">
        <i class="fas fa-cogs me-2"></i> Settings
    </a>
    <div class="collapse submenu {{ $settingsMenuOpen ? 'show' : '' }}" id="settingsMenu">
        <a href="#" class="{{ request()->is('admin/settings/general') ? 'active' : '' }}">General Settings</a>
        <a href="#" class="{{ request()->is('admin/settings/logs') ? 'active' : '' }}">System Logs</a>
    </div>

    {{-- Support --}}
    @php
        $supportMenuOpen = request()->is('admin/support*');
    @endphp
    <a data-bs-toggle="collapse" href="#supportMenu" role="button"
        aria-expanded="{{ $supportMenuOpen ? 'true' : 'false' }}">
        <i class="fas fa-comments me-2"></i> Support
    </a>
    <div class="collapse submenu {{ $supportMenuOpen ? 'show' : '' }}" id="supportMenu">
        <a href="#" class="{{ request()->is('admin/support/chat') ? 'active' : '' }}">Live Chat</a>
        <a href="#" class="{{ request()->is('admin/support/replies') ? 'active' : '' }}">Ticket Replies</a>
    </div>

    {{-- Super Admin --}}
    @php
        $superAdminOpen = request()->is('admin/super-admin*');
    @endphp
    <a data-bs-toggle="collapse" href="#superAdminMenu" role="button"
        aria-expanded="{{ $superAdminOpen ? 'true' : 'false' }}">
        <i class="fas fa-shield-alt me-2"></i> Super Admin
    </a>
    <div class="collapse submenu {{ $superAdminOpen ? 'show' : '' }}" id="superAdminMenu">
        <a href="#" class="{{ request()->is('admin/super-admin/roles') ? 'active' : '' }}">Manage Roles &
            Permissions</a>
        <a href="#" class="{{ request()->is('admin/super-admin/supervisors') ? 'active' : '' }}">Manage Supervisors</a>
        <a href="#" class="{{ request()->is('admin/super-admin/staff') ? 'active' : '' }}">Manage Staff</a>
        <a href="#" class="{{ request()->is('admin/super-admin/logs') ? 'active' : '' }}">System Audit Logs</a>
        <a href="#" class="{{ request()->is('admin/super-admin/plans') ? 'active' : '' }}">Plans & Pricing</a>
    </div>

    {{-- Logout --}}
    <form action="{{ route('logout') }}" method="POST" class="d-inline mt-2">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm">
            <i class="fa fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>