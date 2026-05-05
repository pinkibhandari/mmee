<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
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
            max-width: 120px;
        }

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

        /* Responsive */
        @media (max-width: 768px) {
            .login-card {
                margin-top: -60px;
                padding: 0 10px;
            }
        }
    </style>
</head>

<body>

    <!-- 🔥 Top Section -->
    <div class="top-section">
        <img src="{{ asset('admin/img/logo/logo.png') }}">
        <p>Reset your password easily</p>
    </div>

    <!-- 🔥 Card -->
    <div class="card shadow login-card border-0">
        <div class="card-body p-4">

            <h4 class="text-center fw-bold mb-3">Forgot Password</h4>

            <!-- Info -->
            <p class="text-muted text-center small">
                Enter your email and we will send you a password reset link.
            </p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label>Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="ri-mail-line"></i>
                        </span>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter your email" value="{{ old('email') }}">

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Button -->
                <button class="btn btn-login w-100 text-white py-2">
                    Send Reset Link
                </button>

                <!-- Back to Login -->
                <div class="text-center mt-3">
                    Remember your password?
                    <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">
                        Login
                    </a>
                </div>

            </form>

        </div>
    </div>

</body>
</html>