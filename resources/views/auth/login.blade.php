<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin-Login</title>
    <link href="{{ asset('admin/img/logo/logo.png') }}" rel="icon">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #6777ef;
        }

        /* Top Section */
        .top-section {
            background: white;
            min-height: 220px;
            color: #6777ef;
            text-align: center;
            padding: 30px 15px;
            border-bottom-left-radius: 60% 20%;
            border-bottom-right-radius: 60% 20%;
        }

        /* Login Card */
        .login-card {
            width: 100%;
            max-width: 420px;
            border-radius: 14px;
            margin: -80px auto 0;
        }

        .form-control {
            height: 45px;
            border-radius: 8px;
        }

        .btn-login {
            background: #6777ef;
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-login:hover {
            background: #5a67d8;
            color: #fff;
            opacity: 0.9;
        }
    </style>
</head>

<body>

    <!-- 🔥 Top Section -->
    <div class="top-section">
        <img src="{{ asset('admin/img/logo/logo.png') }}" style="max-width:120px;">
        <p>Welcome back! Login to continue.</p>

    </div>

    <!-- 🔥 Login Card -->
    <div class="card shadow login-card border-0">
        <div class="card-body p-4">

            <h4 class="text-center fw-bold mb-3">Admin Login</h4>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label>Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="ri-mail-line"></i>
                        </span>
                        <input type="email" class="form-control" placeholder="Enter your email" name="email">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label>Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="ri-lock-line"></i>
                        </span>
                        <input type="password" id="password" class="form-control" placeholder="Enter your password"
                            name="password">

                        <span class="input-group-text bg-white" onclick="togglePassword()" style="cursor:pointer;">
                            <i class="ri-eye-line" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <!-- Options -->
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <input type="checkbox" name="remember"> Remember me
                    </div>
                    <a href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                </div>

                <!-- Button -->
                <button class="btn btn-login w-100 text-white py-2">
                    Login
                </button>
                <div>
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary">
                        Sign Up
                    </a>
                </div>
            </form>

        </div>
    </div>

    <!-- Script -->
    <script>
        function togglePassword() {
            let password = document.getElementById("password");
            let icon = document.getElementById("eyeIcon");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.replace("ri-eye-line", "ri-eye-off-line");
            } else {
                password.type = "password";
                icon.classList.replace("ri-eye-off-line", "ri-eye-line");
            }
        }
    </script>

</body>

</html>
