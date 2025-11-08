<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: #fff;
            min-width: 250px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #007bff;
            color: #fff;
        }

        .submenu a {
            padding-left: 2rem;
            display: block;
        }

        .content {
            padding: 20px;
            flex-grow: 1;
        }

        .card-header {
            font-weight: bold;
        }

        :root {
            --sidebar-width: 250px;
            /* default sidebar width */
        }

        body {
            font-family: 'Segoe UI', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: #343a40;
            color: #fff;
            transition: width 0.3s ease, transform 0.3s ease;
            overflow-y: auto;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #007bff;
            color: #fff;
        }

        .submenu a {
            padding-left: 2rem;
        }

        /* Collapsed sidebar */
        .sidebar.collapsed {
            width: 0;
            transform: translateX(-100%);
        }

        /* Content shift */
        .content {
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        /* Responsive: mobile */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
                top: 0;
                left: 0;
                height: 100%;
            }

            .content {
                margin-left: 0;
            }
        }

        .iconStyle {
            font-size: 1.3rem;
            font-weight: 900;
            vertical-align: middle;
            margin-right: 12px;
            color: #fff;
        }

        .required::after {
            content: " *";
            color: red;
            font-weight: bold;
        }

        input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="d-flex">
        @include('partials.admin.sidebar') <!-- Sidebar Partial -->
        <div class="content flex-grow-1">
            @include('partials.admin.header')
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ✅ jQuery (latest stable version, compatible with Bootstrap 5) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-3fnU2x4jzR4QMN3vRyXkQ2JgkpvKfsRj6G2z9Y2w3uM=" crossorigin="anonymous"></script>

    <!-- (Optional) Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoYrD9hY/1yI5Hc5QmQlmNf3p7b6B+8H+Gd5lFJ8YFPCp6p"
        crossorigin="anonymous"></script>

    @stack('scripts')
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userSelect = document.getElementById('chatUserSelect');
            const ticketSelect = document.getElementById('chatTicketSelect');
            const box = document.getElementById('chatMessagesBox');
            const input = document.getElementById('chatMessageInput');
            const sendBtn = document.getElementById('chatSendBtn');

            async function loadMessages() {
                if (!userSelect.value) return;
                const res = await fetch(`{{ route('admin.messages.fetch') }}?receiver_id=${userSelect.value}`);
                const data = await res.json();
                box.innerHTML = '';



                data.forEach(m => {

                    const align = m.sender_id === 1 ? 'text-end' : 'text-start';
                    const color = m.sender_id === 1 ? 'bg-primary text-white' : 'bg-light';




                    const div = document.createElement('div');
                    div.className = `mb-1 p-1 rounded ${align} ${color}`;
                    div.textContent = m.message;
                    box.appendChild(div);
                });
                box.scrollTop = box.scrollHeight;
            }

            userSelect.addEventListener('change', () => {
                if (userSelect.value) {
                    input.disabled = false;
                    sendBtn.disabled = false;
                    loadMessages();
                } else {
                    input.disabled = true;
                    sendBtn.disabled = true;
                }
            });

            sendBtn.addEventListener('click', async () => {
                // alert('h');
                // if (!input.value.trim()) return;
                const formData = new FormData();
                formData.append('receiver_id', userSelect.value);
                formData.append('ticket_id', ticketSelect.value);
                formData.append('message', input.value);
                const res = await fetch(`{{ route('admin.messages.send') }}`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                });
                if (res.ok) {
                    input.value = '';
                    loadMessages();
                }
            });
        });
        userSelect.addEventListener('change', () => {
            if (userSelect.value) {
                input.disabled = false;
                sendBtn.disabled = false;
                input.placeholder = "Type your message...";
                loadMessages();
            } else {
                input.disabled = true;
                sendBtn.disabled = true;
                input.placeholder = "Select a user first...";
            }
        });
        setInterval(() => {
            if (userSelect.value) loadMessages();
        }, 5000);

    </script>


</body>

</html>