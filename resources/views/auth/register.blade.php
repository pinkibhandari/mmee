<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Register</title>
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

        .top-section img {
            max-width: 140px;
        }

        /* Card */
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
        }

        /* 🔥 Responsive Fix */
        @media (max-width: 768px) {

            .top-section {
                min-height: 180px;
                padding: 20px 10px;
            }

            .top-section img {
                max-width: 110px;
            }

            .login-card {
                margin-top: -60px;
                padding: 0 12px;
            }

            .card-body {
                padding: 20px;
            }

            h4 {
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {

            .login-card {
                margin-top: -50px;
            }

            .top-section img {
                max-width: 90px;
            }

            h4 {
                font-size: 16px;
            }

            .form-control {
                height: 42px;
            }
        }
    </style>
</head>

<body>

    <!-- 🔥 Top Section -->
    <div class="top-section">
        <img src="{{ asset('admin/img/logo/logo.png') }}">
        <p class="mt-2">Create your account to continue</p>
    </div>

    <!-- 🔥 Register Card -->
    <div class="card shadow login-card border-0 ">
        <div class="card-body p-4">

            <h4 class="text-center fw-bold mb-3">Admin Register</h4>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label>Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="ri-user-line"></i>
                        </span>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter your name">
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label>Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="ri-mail-line"></i>
                        </span>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter your email">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label>Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="ri-lock-line"></i>
                        </span>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter password">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="ri-lock-password-line"></i>
                        </span>
                        <input type="password" name="password_confirmation"
                            class="form-control"
                            placeholder="Confirm password">
                    </div>
                </div>

                <!-- Button -->
                <button class="btn btn-login w-100 text-white py-2">
                    Register
                </button>

                <!-- Login -->
                <div class="text-center mt-3">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">
                        Login
                    </a>
                </div>

            </form>

        </div>
    </div>

</body>
</html>