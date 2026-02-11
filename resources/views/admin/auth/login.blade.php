<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://img.icons8.com/color/48/admin-settings-male.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #283e51 0%, #485563 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
        }

        .login-card {
            width: 380px;
            border-radius: 18px;
            background: #fff;
            animation: fadeInDown 1s;
            box-shadow: 0 12px 32px 0 rgba(17, 51, 83, 0.10), 0 1.5px 6px 0 rgba(38, 50, 56, 0.16);
            border: none;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: linear-gradient(135deg, #1c92d2 0%, #f2fcfe 100%);
            border-radius: 16px 16px 0 0;
            padding: 26px 16px 16px 16px;
            text-align: center;
            box-shadow: 0 2px 8px 0 rgba(44, 124, 203, 0.09);
        }

        .card-header img {
            width: 52px;
            margin-bottom: 12px;
        }

        .login-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #20486b;
        }

        .form-control:focus {
            border-color: #1c92d2;
            box-shadow: 0 0 0 0.15rem rgba(28, 146, 210, .16);
        }

        .login-btn {
            background: linear-gradient(90deg, #1C92D2, #485563);
            color: #fff;
            font-weight: 600;
            border-radius: 6px;
            transition: background 0.3s, box-shadow 0.3s;
            box-shadow: 0 1.5px 6px 0 rgba(120, 190, 255, 0.11);
        }

        .login-btn:hover {
            background: linear-gradient(90deg, #485563, #1C92D2);
            box-shadow: 0 2px 10px rgba(44, 124, 203, 0.18);
        }

        .form-floating label {
            color: #35759b;
        }

        .forgot-link {
            text-align: right;
            display: block;
            font-size: 0.93em;
            color: #337ab7;
            margin-bottom: 10px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #1c92d2;
            text-decoration: underline;
        }

        .credits {
            text-align: center;
            margin-top: 32px;
            color: #dde4eb;
            font-size: 0.97em;
            letter-spacing: 0.01em;
        }

        .alert-danger {
            border-radius: 5px;
            background: #ffeaea;
            color: #ca1930;
            border: 1px solid #ff9eaf;
            font-size: 0.99em;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card login-card shadow position-relative">
            <div class="card-header">
                <img src="https://img.icons8.com/color/96/admin-settings-male.png" alt="Admin Icon">
                <div class="login-title">Admin Portal Login</div>
                <div class="text-muted" style="font-size:1.01em;font-weight:400;">
                    Welcome! Please sign in to continue.
                </div>
            </div>
            <div class="card-body p-4">
                @if(session('error'))
                <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                @endif

                <form method="POST" action="/admin/login" autocomplete="off" spellcheck="false">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="email" name="email" id="adminEmail" class="form-control" placeholder="Email" required autofocus>
                        <label for="adminEmail"><i class="bi bi-envelope-at-fill me-2"></i>Email Address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" id="adminPassword" class="form-control" placeholder="Password" required>
                        <label for="adminPassword"><i class="bi bi-lock-fill me-2"></i>Password</label>
                    </div>

                    {{-- <a href="#" class="forgot-link">Forgot Password?</a> --}}

                    <button type="submit" class="btn login-btn w-100 py-2">Sign In</button>
                </form>
            </div>
        </div>
    </div>
    <div class="credits">
        &copy; {{ date('Y') }} <b>Admin Dashboard</b> &middot; Powered by <span style="font-weight:600; color: #5cc4ef;">Laravel</span>
    </div>
    <!-- Bootstrap 5 icons CDN for envelope/lock -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</body>

</html>