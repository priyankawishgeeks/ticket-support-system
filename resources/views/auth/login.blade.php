<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ticket Support System</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #f4f7f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            max-width: 450px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .role-radio label {
            margin-right: 20px;
        }

        .btn-login {
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="login-card">
            <h2 class="text-center mb-4">Ticket Support System</h2>
            <p class="text-center text-muted mb-4">Please login to continue</p>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter password" required>
                </div>

                <!-- Roles -->
                <div class="mb-3 role-radio">
                    <label class="form-label d-block"><i class="fas fa-user-tag me-2"></i>Role</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="admin" value="admin" required>
                        <label class="form-check-label" for="admin">Admin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="supervisor" value="supervisor">
                        <label class="form-check-label" for="supervisor">Staff</label>
                    </div>
                    {{-- <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="staff" value="staff">
                        <label class="form-check-label" for="staff"></label>
                    </div> --}}

                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary btn-login mt-3">Login</button>

                <!-- Forgot Password -->
                {{-- <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none">Forgot Password?</a>
                </div> --}}
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>