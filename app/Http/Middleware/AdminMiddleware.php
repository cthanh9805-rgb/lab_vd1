<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Hướng dẫn Lab 03 - Mục 4: Middleware Phân Quyền Admin
     * Kiểm tra người dùng đã đăng nhập và có quyền truy cập quản trị hay không.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->hasAdminAccess()) {
            return $next($request);
        }

        return redirect()->route('welcome')
            ->with('error', '⛔ Bạn không có quyền truy cập vào trang quản trị!');
    }
}
