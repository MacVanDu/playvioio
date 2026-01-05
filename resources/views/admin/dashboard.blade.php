@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-white mb-4 fw-bold">Bảng điều khiển</h2>

        <!-- Hàng 1: Game + Thể loại Game + Blog + Blog Category -->
        <div class="row">
            <!-- Tổng số Game -->
            <div class="col-md-3 mb-4">
                <div class="card bg-gradient-primary shadow text-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Tổng số Game</h6>
                            <h2 class="fw-bold mb-0">{{ \App\Models\Game::count() }}</h2>
                        </div>
                        <i class="fas fa-gamepad fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>

            <!-- Tổng số Thể loại Game -->
            <div class="col-md-3 mb-4">
                <div class="card bg-gradient-success shadow text-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Thể loại Game</h6>
                            <h2 class="fw-bold mb-0">{{ \App\Models\Category::count() }}</h2>
                        </div>
                        <i class="fas fa-folder fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>

            <!-- Tổng số bài blog -->
            <div class="col-md-3 mb-4">
                <div class="card bg-gradient-info shadow text-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Số Game Android</h6>
                            <h2 class="fw-bold mb-0">{{ \App\Models\GameAndroid::count() }}</h2>
                        </div>
                        <i class="fas fa-newspaper fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>

            <!-- Tổng số thể loại blog -->
            <div class="col-md-3 mb-4">
                <div class="card bg-gradient-warning shadow text-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Số Thể loại Android</h6>
                            <h2 class="fw-bold mb-0">{{ \App\Models\CategoryAndroid::count() }}</h2>
                        </div>
                        <i class="fas fa-folder-open fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hàng 2: Game Links + Commands -->
        <div class="row">
            <!-- Game Links chưa có -->
            <div class="col-md-3 mb-4">
                <div class="card bg-dark text-white shadow p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-secondary mb-1">Số Feeback Android</h6>
                            <h2 class="fw-bold mb-0 text-warning">
                                {{ \App\Models\Feedbackff::count() }}
                            </h2>
                        </div>
                        <i class="fas fa-hourglass-half fa-3x opacity-75 text-warning"></i>
                    </div>
                </div>
            </div>
            <!-- Command đang chạy -->
            <div class="col-md-3 mb-4">
                <div class="card bg-gradient-danger shadow text-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Command đang bật</h6>
                            <h2 class="fw-bold mb-0">{{ \App\Models\ScheduledCommand::where('enabled', 1)->count() }}</h2>
                        </div>
                        <i class="fas fa-terminal fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <style>
        body {
            background-color: #0f172a;
        }

        .card {
            border-radius: 14px;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.08);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .text-white {
            color: #e2e8f0 !important;
        }

        .fw-bold {
            font-weight: 700 !important;
        }
    </style>
@endsection