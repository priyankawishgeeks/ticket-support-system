<nav class="navbar bg-white border-bottom shadow-sm py-2">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Left: Brand -->
        <span class="navbar-brand mb-0 h5 text-primary fw-semibold">
            <i class="fas fa-user-shield me-2 text-muted"></i> Agent Dashboard
        </span>

        <!-- Right: User Info -->
        <div class="d-flex align-items-center text-secondary">
            <span class="me-2 small fw-semibold">Logged in as:</span>
            <span class="fw-bold text-dark">{{ auth()->user()->user }}</span>
        </div>
    </div>
</nav>
<style>
    .navbar {
    font-family: 'Inter', 'Segoe UI', sans-serif;
}

.navbar-brand {
    letter-spacing: 0.3px;
}

.text-primary {
    color: #0d6efd !important;
}

.shadow-sm {
    box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
}
.border-bottom {
    border-bottom: 1px solid #dee2e6 !important;
}
</style>