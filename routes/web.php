<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Web Routes - Đường dẫn ứng dụng
|--------------------------------------------------------------------------
*/

// 1. Đăng nhập / Đăng xuất
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Trang chủ
Route::get('/', function () {
    return redirect()->route('products.index');
});

// 3. TOÀN BỘ KHU VỰC ADMIN (Đã bọc Middleware CheckAdmin)
Route::middleware(['admin'])->group(function () {
    
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
