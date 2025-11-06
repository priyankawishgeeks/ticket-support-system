<div class="nav-top">
    <h5>Client Dashboard</h5>
    <div class="d-flex gap-3">
        <a href="{{ route('user.open_ticket') }}"class="btn btn-outline-primary btn-sm">Open Ticket</a>
        <form action="{{ route('client.logout') }}" method="POST">@csrf
            <button class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i>
                Logout</button>
        </form>
    </div>

</div>