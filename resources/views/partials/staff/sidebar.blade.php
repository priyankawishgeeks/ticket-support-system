<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3 bg-white border-end shadow-sm" style="min-height: 100vh; width: 240px;">
    <h5 class="text-center text-primary fw-semibold mb-4">Agent Panel</h5>

    <!-- Dashboard -->
    <a href="{{ route('agent.dashboard') }}"
        class="d-flex align-items-center py-2 px-3 mb-1 rounded-2 text-decoration-none text-secondary fw-semibold {{ request()->routeIs('agent.dashboard') ? 'bg-primary text-white' : 'hover-bg-light' }}">
        <i class="fas fa-tachometer-alt me-2 text-muted"></i> Dashboard
    </a>

    <!-- Tickets -->
    @php $ticketMenuOpen = request()->is('agent/tickets*'); @endphp
    <a data-bs-toggle="collapse" href="#ticketsMenu" role="button"
        aria-expanded="{{ $ticketMenuOpen ? 'true' : 'false' }}"
        class="d-flex align-items-center py-2 px-3 mb-1 rounded-2 text-decoration-none text-secondary fw-semibold hover-bg-light">
        <i class="fas fa-ticket-alt me-2 text-muted"></i> Tickets
        <i class="ms-auto fas fa-chevron-right small transition {{ $ticketMenuOpen ? 'rotate-90' : '' }}"></i>
    </a>
    <div class="collapse submenu {{ $ticketMenuOpen ? 'show' : '' }}" id="ticketsMenu">
        <a href="{{ route('agent.tickets.assigned') }}"
            class="d-block py-2 ps-5 pe-3 text-secondary small {{ request()->routeIs('agent.tickets.assigned') ? 'text-primary fw-semibold' : 'hover-text-dark' }}">
            <i class="bi bi-record-circle-fill me-1 small"></i> Assigned Tickets
        </a>
    </div>

    <!-- Users -->
    @php $SuteUserMenuOpen = request()->is('agent/site-users*'); @endphp
    <a data-bs-toggle="collapse" href="#siteUserMenu" role="button"
        aria-expanded="{{ $SuteUserMenuOpen ? 'true' : 'false' }}"
        class="d-flex align-items-center py-2 px-3 mb-1 rounded-2 text-decoration-none text-secondary fw-semibold hover-bg-light">
        <i class="fas fa-users me-2 text-muted"></i> Users
        <i class="ms-auto fas fa-chevron-right small transition {{ $SuteUserMenuOpen ? 'rotate-90' : '' }}"></i>
    </a>
    <div class="collapse submenu {{ $SuteUserMenuOpen ? 'show' : '' }}" id="siteUserMenu">
        <a href="{{ route('agent.site_users.tickets') }}"
            class="d-block py-2 ps-5 pe-3 text-secondary small {{ request()->routeIs('agent.site_users.*') ? 'text-primary fw-semibold' : 'hover-text-dark' }}">
            <i class="bi bi-record-circle-fill me-1 small"></i> All Users
        </a>
    </div>

    <!-- Support -->
    <a data-bs-toggle="collapse" href="#supportMenu" role="button"
        class="d-flex align-items-center py-2 px-3 mb-1 rounded-2 text-decoration-none text-secondary fw-semibold hover-bg-light">
        <i class="fas fa-comments me-2 text-muted"></i> Support
        <i class="ms-auto fas fa-chevron-right small transition"></i>
    </a>
    <div class="collapse submenu" id="supportMenu">
        <a href="#" class="d-block py-2 ps-5 pe-3 text-secondary small hover-text-dark">
            Live Chat
        </a>
        <a href="#" class="d-block py-2 ps-5 pe-3 text-secondary small hover-text-dark">
            Ticket Replies
        </a>
    </div>

    <div class="mt-auto pt-3 border-top">
        <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
            @csrf
            <button type="submit"
                class="btn btn-outline-danger btn-sm w-100 mt-2 fw-semibold d-flex align-items-center justify-content-center">
                <i class="fa fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
</div>
<style>
    .hover-bg-light:hover {
    background-color: #f8f9fa;
}

.hover-text-dark:hover {
    color: #212529 !important;
}

.transition {
    transition: all 0.2s ease;
}

.rotate-90 {
    transform: rotate(90deg);
}

</style>