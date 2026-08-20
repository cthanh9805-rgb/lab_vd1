<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Web Routes - Hướng dẫn Lab 03: Xác thực & Phân quyền Người Dùng
|--------------------------------------------------------------------------
*/

// 1. TRANG CHỦ CỬA HÀNG KHÁCH HÀNG (LAB 03 - SECTION 7)
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/shop/{product}', [ProductController::class, 'show_normal'])->name('products.show_normal');

// 2. XÁC THỰC ĐĂNG KÝ & ĐĂNG NHẬP (LAB 03 - SECTION 1 & 2)
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. TOÀN BỘ KHU VỰC QUẢN TRỊ ADMIN (LAB 03 - SECTION 4 & 11)
Route::middleware(['admin'])->group(function () {
    
    // Trang Dashboard Admin (Lab 03 - Section 11)
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Profile cá nhân & Đổi mật khẩu
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Lịch sử hoạt động hệ thống
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    // Resource Danh mục
    Route::resource('categories', CategoryController::class);

    // Route đặc biệt Sản phẩm
    Route::get('products/trash', [ProductController::class, 'trash'])->name('products.trash');
    Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
    Route::get('products/export', [ProductController::class, 'export'])->name('products.export');

    // Resource Sản phẩm
    Route::resource('products', ProductController::class);

    // Route đặc biệt Người dùng (Xuất CSV)
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    // Resource Người dùng
    Route::resource('users', UserController::class);
});
