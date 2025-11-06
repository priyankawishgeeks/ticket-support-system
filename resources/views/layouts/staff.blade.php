<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>@yield('title')</title>

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
        }

        .submenu a {
            padding-left: 2rem;
            display: block;
        }

        .content {
            padding: 20px;
            flex-grow: 1;
        }

        .dashboard-card {
            color: #fff;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }

        .blur-bg {
            background: rgba(0, 123, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        #liveChatBox,
        #ticketReplies {
            height: 350px;
            overflow-y: auto;
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="d-flex">

        @include('partials.staff.sidebar')

        <!-- Main Content -->
        <div class="content flex-grow-1">

            @include('partials.staff.header')


            @yield('staff')


        </div> <!-- content -->
    </div> <!-- d-flex -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ✅ jQuery (latest stable version, compatible with Bootstrap 5) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-3fnU2x4jzR4QMN3vRyXkQ2JgkpvKfsRj6G2z9Y2w3uM=" crossorigin="anonymous"></script>

    <!-- (Optional) Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoYrD9hY/1yI5Hc5QmQlmNf3p7b6B+8H+Gd5lFJ8YFPCp6p"
        crossorigin="anonymous"></script>

   
   
   @stack('scripts')

   
   

</body>

</html>