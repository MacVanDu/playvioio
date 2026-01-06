<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang Quản Trị')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* ========== RESET + BASE ========== */
        body {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: "Inter", sans-serif;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: 240px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background: linear-gradient(180deg, #111827, #1e293b);
            transition: all 0.3s ease;
            padding-top: 25px;
            z-index: 1060;
        }

        .sidebar h4 {
            color: #22d3ee;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .sidebar a {
            display: block;
            padding: 12px 25px;
            color: #94a3b8;
            font-weight: 500;
            transition: 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: linear-gradient(90deg, #4f46e5, #22d3ee);
            color: #fff;
        }

        /* ========== CONTENT ========== */
        .content {
            margin-left: 240px;
            min-height: 100vh;
            background: linear-gradient(180deg, #0f172a, #111827);
            transition: margin-left 0.3s ease;
        }

        /* ========== NAVBAR ========== */
        .navbar {
            background: #1e293b;
            border-bottom: 1px solid #334155;
            padding: 12px 20px;
            position: sticky;
            top: 0;
            z-index: 1070;
        }

        .navbar h5 {
            color: #fff;
            margin: 0;
            font-weight: 600;
        }

        #toggleSidebar {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 22px;
        }

        .logout-btn {
            color: #f87171;
            text-decoration: none;
            font-weight: 600;
        }

        .logout-btn:hover {
            color: #ef4444;
        }

        /* ========== FOOTER ========== */
        footer {
            text-align: center;
            padding: 15px;
            color: #9ca3af;
            background: #111827;
            border-top: 1px solid #273449;
            font-size: 13px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0 !important;
            }

            #toggleSidebar {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.8);
            z-index: 1055;
            display: none;
        }

        .overlay.active {
            display: block;
        }

        /* ========== TABLE STYLE ========== */
        .table {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
            border-collapse: separate !important;
            border-spacing: 0 6px !important;
        }

        .table thead th {
            background: #1e293b !important;
            color: #60a5fa !important;
            font-weight: 600;
            font-size: 12px;
            border: none !important;
        }

        .table tbody tr {
            background: #1e293b !important;
            border: 1px solid #273449 !important;
        }

        .table tbody tr:hover {
            background: #243554 !important;
        }

        .table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #334155;
            transition: 0.3s;
        }

        .table img:hover {
            transform: scale(1.05);
            border-color: #22d3ee;
        }

        .table a {
            color: #fff !important;
            font-weight: 600;
        }

        .table a:hover {
            color: #60a5fa !important;
        }

        /* ========== BUTTONS ========== */
        .btn-gradient {
            background: linear-gradient(90deg, #6366f1, #22d3ee);
            color: #fff;
            font-weight: 600;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.25s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(90deg, #4f46e5, #0ea5e9);
            transform: translateY(-2px);
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .btn-action.edit {
            background: linear-gradient(135deg, #3b82f6, #22d3ee);
            color: #fff;
        }

        .btn-action.delete {
            background: linear-gradient(135deg, #f43f5e, #dc2626);
            color: #fff;
        }

        .btn-action.view {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }

        /* ========== PAGINATION ========== */
        .pagination {
            justify-content: center;
            gap: 8px;
            margin-top: 25px;
        }

        .page-link {
            background: #1e293b !important;
            color: #cbd5e1 !important;
            border: 1px solid #334155 !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
        }

        .page-item.active .page-link {
            background: linear-gradient(90deg, #6366f1, #22d3ee) !important;
            color: #fff !important;
            border: none !important;
        }

        /* ========== SELECT2 DARK THEME ========== */
        .select2-container--default .select2-selection--single {
            background-color: #1e293b;
            border: 1px solid #334155;
            color: #f1f5f9;
            height: 40px;
            border-radius: 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #f1f5f9;
            line-height: 38px;
        }

        .select2-dropdown {
            background-color: #1e293b;
            border: 1px solid #475569;
            color: #fff;
        }

        .select2-results__option--highlighted {
            background-color: #3b82f6 !important;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Quản Trị</h4>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">🏠 Tổng quan</a>
        <a href="{{ route('admin.games.index') }}" class="{{ request()->is('admin/games*') ? 'active' : '' }}">🎮 Quản lý Game</a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">🧩 Thể loại Game</a>
        <a href="{{ route('admin.settings.index') }}" class="{{ request()->is('admin/settings*') ? 'active' : '' }}">⚙️ Cấu hình hệ thống</a>

    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Content -->
    <div class="content">
        <nav class="navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <button id="toggleSidebar" class="d-lg-none">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0">Trang quản trị</h5>
            </div>

            <a href="{{ route('admin.logout') }}" class="logout-btn"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>

            <form id="logout-form" action="{{ route('admin.logout') }}" method="GET" class="d-none">
                @csrf
            </form>
        </nav>

<main class="px-2 py-2 px-md-4 py-md-4">
    @yield('content')
</main>


        <footer>
            © {{ date('Y') }} - Admin Dashboard by Apkgosu
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.overlay');

            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });

            $('.select2-search').select2({
                placeholder: "Chọn thể loại...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</body>
@include('admin.layouts.css')
</html>
