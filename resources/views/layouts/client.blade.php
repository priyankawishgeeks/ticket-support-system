<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - {{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', sans-serif;
        }

        .content {
            flex-grow: 1;
            padding: 30px;
        }

        .nav-top {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        footer {
            background: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        .client-menu-sidebar {
            background: #3497da;
            color: #fff;
            width: 350px;
            min-height: 100vh;
            padding: 20px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
            position: relative;
        }

        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .subscription-label {
            position: absolute;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            padding: 2px 8px;
            font-size: 12px;
            border-radius: 22px;
            width: 100%;
        }

        .client-my-menu {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .client-my-menu li {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .client-my-menu li:last-child {
            border-bottom: none;
        }

        .client-my-menu a {
            display: block;
            padding: 10px 15px;
            color: #fff;
            text-decoration: none;
        }

        .client-my-menu a.active,
        .client-my-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        @include('partials.client.sidebar')
        <div class="flex-grow-1">
            @include('partials.client.header')
            <div class="content">
                @yield('client_content')
            </div>
        </div>
    </div>

    <footer>
        © {{ date('Y') }} Support System — All Rights Reserved.
    </footer>

    <!-- ✅ jQuery & Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ Blade stack for per-page scripts -->
    @stack('scripts')
</body>

</html>