<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes - Đường dẫn ứng dụng
|--------------------------------------------------------------------------
*/

// 1. Trang chủ
Route::get('/', function () {
    return redirect()->route('products.index');
});

// 2. Resource Route cho Danh mục
Route::resource('categories', CategoryController::class);

// 3. Sản phẩm – Các route đặc biệt (phải đặt TRƯỚC resource)
Route::get('products/trash', [ProductController::class, 'trash'])->name('products.trash');
Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
Route::get('products/export', [ProductController::class, 'export'])->name('products.export');

// 4. Resource Route cho Sản phẩm
Route::resource('products', ProductController::class);
