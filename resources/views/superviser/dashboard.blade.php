<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard - Ticket Support System</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: #fff;
            width: 250px;
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
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column p-3">
            <h4 class="text-center py-3">Supervisor Panel</h4>

            <a href="#" class="active"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>

            <a data-bs-toggle="collapse" href="#ticketsMenu" role="button"><i class="fas fa-ticket-alt me-2"></i>
                Tickets</a>
            <div class="collapse submenu" id="ticketsMenu">
                <a href="#">All Assigned Tickets</a>
                <a href="#">Create Ticket</a>
            </div>

            <a data-bs-toggle="collapse" href="#usersMenu" role="button"><i class="fas fa-users me-2"></i> Users</a>
            <div class="collapse submenu" id="usersMenu">
                <a href="#">All Users</a>
            </div>

            <a data-bs-toggle="collapse" href="#supportMenu" role="button"><i class="fas fa-comments me-2"></i>
                Support</a>
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

        <!-- Main Content -->
        <div class="content flex-grow-1">
            <!-- Header -->
            <nav class="navbar navbar-light bg-light mb-4">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Supervisor Dashboard</span>
                    <div>
                        Logged in as: <strong>Supervisor</strong>
                    </div>
                </div>
            </nav>

            <!-- Dashboard Cards -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Assigned Tickets</h5>
                            <p class="card-text">50 Total</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Users Managed</h5>
                            <p class="card-text">20 Total</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Open Tickets</h5>
                            <p class="card-text">8</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Live Chat & Ticket Replies -->
            <div class="row mb-4">
                <!-- Live Chat Box -->
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">Live Chat Support</div>
                        <div class="card-body" style="height: 400px; overflow-y: auto;" id="liveChatBox">
                            <div><strong>John Doe:</strong> I have an issue with my login.</div>
                            <div><strong>Supervisor:</strong> Please provide more details.</div>
                        </div>
                        <div class="card-footer">
                            <form id="chatForm">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Type a message"
                                        id="chatMessage" required>
                                    <button class="btn btn-primary" type="submit">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Ticket Replies -->
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">Ticket Replies</div>
                        <div class="card-body" style="height: 400px; overflow-y: auto;" id="ticketReplies">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Ticket ID</th>
                                        <th>User</th>
                                        <th>Reply</th>
                                        <th>Assigned To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>101</td>
                                        <td>John Doe</td>
                                        <td>Cannot login to dashboard</td>
                                        <td>Supervisor</td>
                                        <td>
                                            <button class="btn btn-sm btn-success">Reply</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>102</td>
                                        <td>Jane Smith</td>
                                        <td>Password reset not working</td>
                                        <td>Supervisor</td>
                                        <td>
                                            <button class="btn btn-sm btn-success">Reply</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- content -->
    </div> <!-- d-flex -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const chatForm = document.getElementById('chatForm');
        const chatBox = document.getElementById('liveChatBox');

        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const msg = document.getElementById('chatMessage').value;
            if (msg.trim() !== '') {
                const div = document.createElement('div');
                div.innerHTML = `<strong>Supervisor:</strong> ${msg}`;
                chatBox.appendChild(div);
                chatBox.scrollTop = chatBox.scrollHeight; // scroll to bottom
                chatForm.reset();
            }
        });
    </script>
</body>

</html>