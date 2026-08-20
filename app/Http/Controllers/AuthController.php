<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Hướng dẫn Lab 03: Hiển thị Form Đăng Ký
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return Auth::user()->hasAdminAccess() 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('welcome');
        }
        return view('auth.register');
    }

    // Hướng dẫn Lab 03: Xử lý Đăng Ký Người Dùng
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            Log::info('Registering user with email: ' . $request->email);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'customer', // Mặc định là khách hàng theo Lab 03
                'status'   => 'active',
            ]);

            Log::info('User registered successfully');

            return redirect()->route('login')
                ->with('success', 'Đăng ký tài khoản thành công! Vui lòng đăng nhập.');
        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Đăng ký không thành công. Vui lòng thử lại.');
        }
    }

    // Hướng dẫn Lab 03: Hiển thị Form Đăng Nhập
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->hasAdminAccess() 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('welcome');
        }
        return view('auth.login');
    }

    // Hướng dẫn Lab 03: Xử lý Đăng Nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Kiểm tra trạng thái bị khoá
            if ($user->status === 'blocked') {
                Auth::logout();
                $request->session()->invalidate();
                return back()->withErrors(['email' => '🔒 Tài khoản của bạn đã bị khoá. Vui lòng liên hệ Admin.']);
            }

            $user->update(['last_login_at' => now()]);
            $request->session()->regenerate();

            // Điều hướng theo vai trò (Phân quyền theo Lab 03)
            if ($user->hasAdminAccess()) {
                ActivityLog::record('login', 'Đăng nhập vào Trang Quản Trị');
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Đăng nhập thành công! Chào mừng ' . $user->name . ' 👋');
            }

            ActivityLog::record('login', 'Đăng nhập vào Cửa Hàng');
            return redirect()->intended(route('welcome'))
                ->with('success', 'Chào mừng ' . $user->name . ' đã quay trở lại cửa hàng! 🛍️');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    // Hướng dẫn Lab 03: Xử lý Đăng Xuất
    public function logout(Request $request)
    {
        if (Auth::check()) {
            ActivityLog::record('logout', 'Đã đăng xuất');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đã đăng xuất thành công!');
    }
}
