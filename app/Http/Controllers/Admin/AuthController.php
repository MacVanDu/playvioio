<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return back()->with('error', 'Tài khoản này không có quyền quản trị.');
            }
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng.');
    }

    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
