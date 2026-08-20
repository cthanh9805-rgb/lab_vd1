<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->hasAdminAccess()) {
                return redirect()->route('products.index');
            }
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // 1. Kiểm tra nếu bị khoá
            if ($user->status === 'blocked') {
                Auth::logout();
                $request->session()->invalidate();
                return back()->withErrors(['email' => '🔒 Tài khoản của bạn đã bị khoá. Vui lòng liên hệ Admin.']);
            }

            // 2. Kiểm tra nếu là Khách hàng (không có quyền vào Admin)
            if (!$user->hasAdminAccess()) {
                Auth::logout();
                $request->session()->invalidate();
                return back()->withErrors(['email' => '⛔ Tài khoản khách hàng không có quyền đăng nhập vào Trang Quản Trị Admin!']);
            }

            $user->update(['last_login_at' => now()]);
            $request->session()->regenerate();

            ActivityLog::record('login', 'Đã đăng nhập vào trang quản trị');

            return redirect()->intended(route('products.index'))
                ->with('success', 'Đăng nhập thành công! Chào mừng ' . $user->name . ' 👋');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            ActivityLog::record('logout', 'Đã đăng xuất khỏi trang quản trị');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đã đăng xuất thành công!');
    }
}
