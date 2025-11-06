<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
    <h4 class="text-center py-3">Agent Panel</h4>

    <a href="{{ route('agent.dashboard') }}" class="{{ request()->routeIs('agent.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>

    @php
        $ticketMenuOpen = request()->is('agent/tickets*');
    @endphp
    <a data-bs-toggle="collapse" href="#ticketsMenu" role="button"
        aria-expanded="{{ $ticketMenuOpen ? 'true' : 'false' }}">
        <i class="fas fa-ticket-alt me-2"></i> Tickets
    </a>
    <div class="collapse submenu {{ $ticketMenuOpen ? 'show' : '' }}" id="ticketsMenu">
        {{-- <a href="{{ route('agent.tickets') }}"
            class="{{ request()->routeIs('agent.tickets.*') ? 'active' : '' }}"><i
                class="bi bi-record-circle-fill  "></i> All Tickets</a> --}}
        <a href="{{ route('agent.tickets.assigned') }}"
            class="{{ request()->routeIs('agent.tickets.assigned') ? 'active' : '' }}"><i
                class="bi bi-record-circle-fill  "></i> Assigned Tickets</a>
    </div>

    @php
        $SuteUserMenuOpen = request()->is('agent/site-users*');
    @endphp
    <a data-bs-toggle="collapse" href="#siteUserMenu" role="button"
        aria-expanded="{{ $SuteUserMenuOpen ? 'true' : 'false' }}">
        <i class="fas fa-users me-2"></i> Users
    </a>
    <div class="collapse submenu {{ $SuteUserMenuOpen ? 'show' : '' }}" id="siteUserMenu">
        <a href="{{ route('agent.site_users.tickets') }}"
            class="{{ request()->routeIs('agent.site_users.*') ? 'active' : '' }}"><i
                class="bi bi-record-circle-fill  "></i> All Users</a>

    </div>

    <a data-bs-toggle="collapse" href="#supportMenu" role="button">
        <i class="fas fa-comments me-2"></i> Support
    </a>
    <div class="collapse submenu" id="supportMenu">
        <a href="#">Live Chat</a>
        <a href="#">Ticket Replies</a>
    </div>

    <form action="{{ route('logout') }}" method="POST" class="d-inline mt-2">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm">
            <i class="fa fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>