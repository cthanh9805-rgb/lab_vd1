<?php

use Illuminate\Support\Facades\Route;

// 1. IMPORT PACAKGE CUSTOMER
use App\Http\Controllers\Customer\WelcomeController;

// 2. IMPORT PACKAGE AUTH
use App\Http\Controllers\Auth\AuthController;

// 3. IMPORT PACKAGE ADMIN
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Web Routes - Đường Dẫn Ứng Dụng (Đã Phân Chia Theo Package Nền Tảng)
|--------------------------------------------------------------------------
*/

// 🛒 KHU VỰC CỬA HÀNG KHÁCH HÀNG (CUSTOMER PACKAGE)
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/shop/{product}', [ProductController::class, 'show_normal'])->name('products.show_normal');

// 🔑 KHU VỰC XÁC THỰC DÙNG CHUNG (AUTH PACKAGE)
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 👑 KHU VỰC QUẢN TRỊ ADMIN (ADMIN PACKAGE - BỌC MIDDLEWARE ADMIN)
Route::middleware(['admin'])->group(function () {
    
    // Trang Dashboard Admin
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
