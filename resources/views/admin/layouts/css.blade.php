<style>
        body {
            background-color: #0f172a;
            color: #fff;
            font-family: "Inter", sans-serif;
            overflow-x: hidden;
        }

        

        .content {
            margin-left: 240px;
            min-height: 100vh;
            padding: 0;
            background: linear-gradient(180deg, #0f172a, #111827);
        }

        .navbar {
            background: #1e293b;
            border-bottom: 1px solid #334155;
            padding: 10px 20px;
        }

        .navbar h5 {
            color: #fff;
            margin: 0;
            font-weight: 600;
        }

        .logout-btn {
            color: #f87171;
            text-decoration: none;
            font-weight: 600;
        }

        .logout-btn:hover {
            text-decoration: underline;
            color: #ef4444;
        }

        footer {
            text-align: center;
            padding: 15px;
            color: #9ca3af;
            background: #111827;
            border-top: 1px solid #273449;
            font-size: 13px;
        }
    </style>

    
<style>
    /* Ép bảng sang nền tối hoàn toàn */
    .table {
        background-color: #0f172a !important;
        color: #e2e8f0 !important;
        border-collapse: separate !important;
        border-spacing: 0 1px !important;
    }

    .table thead {
        background-color: #111827 !important;
        border-bottom: 1px solid #334155 !important;
    }

    .table thead th {
        background: #1e293b !important;
        color: #60a5fa !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        border: none !important;
        justify-content: center;
        align-items: center;
    }

    /* Các hàng dữ liệu */
    .table tbody tr {
        background: #1e293b !important;
        border: 1px solid #273449 !important;
    }

    .table tbody tr:nth-child(even) {
        background: #162133 !important;
    }

    .table tbody tr:hover {
        background: #243554 !important;
        box-shadow: 0 0 6px rgba(56, 189, 248, 0.15);
    }

    /* Cột */
    .table td {
        background: transparent !important;
        color: #e2e8f0 !important;
        vertical-align: middle !important;
        border: none !important;
        padding: 12px 16px !important;
    }

    .table td:first-child {
        color: #a5b4fc !important;
        font-weight: 500;
    }

    /* Ảnh Game */
    .table img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #334155;
        transition: 0.3s;
    }

    .table img:hover {
        transform: scale(1.05);
        border-color: #22d3ee;
    }

    /* Link xanh */
    .table a {
        color: #fff !important;
        text-decoration: none;
        font-weight: 600;
    }

    .table a:hover {
        color: #60a5fa !important;
        text-decoration: underline;
    }

    /* Badge */
    .badge {
        font-size: 12px !important;
        padding: 6px 10px !important;
        border-radius: 8px !important;
    }

    .bg-success {
        background: linear-gradient(90deg, #22c55e, #16a34a) !important;
        color: #fff !important;
    }

    .bg-secondary {
        background: #475569 !important;
        color: #fff !important;
    }

    /* Nút Sửa / Xóa */
    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-action.edit {
        background: linear-gradient(135deg, #3b82f6, #22d3ee) !important;
        color: #fff;
    }

    .btn-action.delete {
        background: linear-gradient(135deg, #f43f5e, #dc2626) !important;
        color: #fff;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 8px rgba(255, 255, 255, 0.2);
    }

    /* Nút thêm mới */
    .btn-gradient {
        background: linear-gradient(90deg, #6366f1, #22d3ee);
        color: #fff;
        font-weight: 600;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        transition: all 0.25s ease;
    }

    .btn-gradient:hover {
        background: linear-gradient(90deg, #4f46e5, #0ea5e9);
        transform: translateY(-2px);
    }

    /* Phân trang */
    .pagination {
        display: flex;
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
        transition: all 0.25s;
    }

    .page-item.active .page-link {
        background: linear-gradient(90deg, #6366f1, #22d3ee) !important;
        color: #fff !important;
        border: none !important;
    }

    .page-link:hover {
        background: #334155 !important;
        color: #fff !important;
    }

    /* Xóa dòng pagination "Showing X to Y" */
    p.small.text-muted {
        display: none !important;
    }

    .table td .text-muted {
        color: #b6b6b6ff !important;
    }

    .btn-action.view {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
    }

    .btn-action.view:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.6);
    }
</style>
<style>
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
        padding-left: 10px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #f1f5f9 transparent transparent transparent;
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