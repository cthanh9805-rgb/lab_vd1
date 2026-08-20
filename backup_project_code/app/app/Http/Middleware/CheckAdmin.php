<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để truy cập trang quản trị!');
        }

        $user = Auth::user();

        // 1. Kiểm tra tài khoản bị khoá
        if ($user->status === 'blocked') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => '🔒 Tài khoản của bạn đã bị khoá. Vui lòng liên hệ Admin!',
            ]);
        }

        // 2. Kiểm tra quyền truy cập Admin (Super Admin, Admin, Staff)
        if (!$user->hasAdminAccess()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => '⛔ Tài khoản khách hàng không có quyền truy cập khu vực Admin!',
            ]);
        }

        return $next($request);
    }
}
