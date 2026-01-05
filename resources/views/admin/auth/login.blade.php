<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Quản Trị</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(180deg,#0f172a 0%,#1e293b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: #e2e8f0;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
            background: #1e293b;
            padding: 32px 26px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 28px;
            font-weight: 700;
            color: #f8fafc;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #cbd5e1;
        }

        .form-control {
            background-color: #0f172a;
            color: #f1f5f9;
            border: 1px solid #334155;
            border-radius: 8px;
            transition: all .25s;
        }
        .form-control:focus {
            background-color: #1e293b;
            border-color: #22d3ee;
            box-shadow: 0 0 6px rgba(34,211,238,0.4);
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(90deg, #6366f1, #22d3ee);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 10px 0;
            margin-top: 8px;
            transition: all .25s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            background: linear-gradient(90deg, #4f46e5, #0ea5e9);
            box-shadow: 0 4px 10px rgba(59,130,246,0.3);
        }

        .alert {
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
        }

        small {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #64748b;
            font-size: 13px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 24px 20px;
                border-radius: 10px;
            }
            .login-card h2 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h2><i class="fas fa-user-shield me-2 text-info"></i>Đăng nhập Admin</h2>

        @if(session('error'))
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Nhập email quản trị" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
            </button>
        </form>

        <small>© {{ date('Y') }} Hệ thống quản trị</small>
    </div>

    <!-- FontAwesome & Bootstrap JS -->
    <script src="https://kit.fontawesome.com/a2e0a1c6d3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
